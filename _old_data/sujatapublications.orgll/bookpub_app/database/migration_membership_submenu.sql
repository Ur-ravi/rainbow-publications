-- ============================================================
-- Membership dropdown cleanup (idempotent, safe to re-run)
-- ============================================================
-- Goal:
--   1. Top-level navbar item: "Membership" (just a dropdown trigger)
--   2. Two children under it:
--        - Apply Now     -> /membership/types          (the application form)
--        - View Details  -> /membership/types-details  (the new detailed-view modal page)
--   3. Remove any standalone top-level "Membership Types" item.
--   4. Restore the original "/membership" parent URL/label if a previous
--      migration had renamed it to "Membership Types".

-- 1. Restore the parent label and URL: "Membership" -> /membership
UPDATE menus
SET label = 'Membership', url = '/membership'
WHERE label = 'Membership Types'
  AND parent_id IS NULL
  AND url = '/membership-types';

-- 2. Make sure the parent "Membership" -> /membership exists at top level
INSERT INTO menus (parent_id, label, url, sort_order, is_active)
SELECT NULL, 'Membership', '/membership', 5, 1
FROM DUAL
WHERE NOT EXISTS (SELECT 1 FROM menus WHERE url = '/membership' AND parent_id IS NULL);

-- 3. Remove the duplicate standalone "Membership Types" top-level item
--    (only if it has no children — otherwise it's still the parent we want).
DELETE FROM menus
WHERE label = 'Membership Types'
  AND url   = '/membership-types'
  AND parent_id IS NULL
  AND id NOT IN (SELECT DISTINCT parent_id FROM menus WHERE parent_id IS NOT NULL);

-- 4. Make sure the "Apply Now" child exists under "Membership"
INSERT INTO menus (parent_id, label, url, sort_order, is_active)
SELECT m.id, 'Apply Now', '/membership/types', 1, 1
FROM menus m
WHERE m.url = '/membership' AND m.parent_id IS NULL
AND NOT EXISTS (
    SELECT 1 FROM menus c WHERE c.parent_id = m.id AND c.url = '/membership/types'
);

-- 5. Add the "View Details" child (links to the new detailed-view page)
INSERT INTO menus (parent_id, label, url, sort_order, is_active)
SELECT m.id, 'View Details', '/membership/types-details', 2, 1
FROM menus m
WHERE m.url = '/membership' AND m.parent_id IS NULL
AND NOT EXISTS (
    SELECT 1 FROM menus c WHERE c.parent_id = m.id AND c.url = '/membership/types-details'
);

-- 6. Clean up: if a previous migration had placed "Apply Now" or "View Details"
--    as children of a "Membership Types" parent, move them under the real
--    "Membership" parent (idempotent — skips if already in the right place).
UPDATE menus child
JOIN menus oldParent ON child.parent_id = oldParent.id
JOIN menus newParent ON newParent.url = '/membership' AND newParent.parent_id IS NULL
SET child.parent_id = newParent.id
WHERE oldParent.label = 'Membership Types'
  AND oldParent.url   = '/membership-types'
  AND oldParent.parent_id IS NULL
  AND child.label IN ('Apply Now', 'View Details');

-- 7. After step 6, the now-orphaned "Membership Types" parent (if empty) can be removed
DELETE FROM menus
WHERE label = 'Membership Types'
  AND url   = '/membership-types'
  AND parent_id IS NULL
  AND id NOT IN (SELECT DISTINCT parent_id FROM menus WHERE parent_id IS NOT NULL);