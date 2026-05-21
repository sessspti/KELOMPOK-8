# Implementation Plan: store-status-product-visibility

## Overview

This document contains the implementation tasks for the store-status-product-visibility feature. Tasks are ordered to ensure dependencies are met and implementation can proceed incrementally.

## Task List

### Phase 1: Model Extensions

#### 1.1 Add scopes and accessors to Menu model

**Description:** Add scopeAvailable, scopeFromOpenStore, scopeVisibleForPublic, getDisplayStatusAttribute, and getIsVisibleAttribute to the Menu model.

**Implementation Details:**
- Add `scopeAvailable($query)` - filters where stock > 0
- Add `scopeFromOpenStore($query)` - filters where seller.store_status = 'Buka'
- Add `scopeVisibleForPublic($query)` - chains available() and fromOpenStore()
- Add `getDisplayStatusAttribute()` - returns 'Tersedia', 'Tutup', or 'Habis'
- Add `getIsVisibleAttribute()` - returns boolean for visibility

**File:** `app/Models/Menu.php`

**Acceptance Criteria:**
- [x] scopeAvailable returns only products with stock > 0
- [x] scopeFromOpenStore returns only products from stores with status 'Buka'
- [x] scopeVisibleForPublic combines both scopes
- [x] getDisplayStatusAttribute returns correct status string
- [x] getIsVisibleAttribute returns true only if stock > 0 AND store is open

**Testing:**
- Run unit tests for Menu model scopes
- Test with Laravel tinker

---

#### 1.2 Add store status accessors to User model

**Description:** Add store_status_display and is_store_open accessors to User model for sellers.

**Implementation Details:**
- Add `getStoreStatusDisplayAttribute()` - returns 'Buka' or 'Tutup'
- Add `getIsStoreOpenAttribute()` - returns boolean

**File:** `app/Models/User.php`

**Acceptance Criteria:**
- [x] getStoreStatusDisplayAttribute returns readable status
- [x] getIsStoreOpenAttribute returns true only if store_status === 'Buka'

**Testing:**
- Run unit tests for User model accessors
- Test with Laravel tinker

---

### Phase 2: Service Layer

#### 2.1 Create ProductVisibilityService

**Description:** Create a new service class to handle product visibility logic centrally.

**Implementation Details:**
- Create `app/Services/ProductVisibilityService.php`
- Implement `getVisibleProductsForConsumer()` method
- Implement `getVisibleProductsForInstitution()` method
- Implement `getAllProductsForSeller($sellerId)` method
- Implement `checkVisibilityAfterStockChange(Menu $product)` method

**File:** `app/Services/ProductVisibilityService.php`

**Acceptance Criteria:**
- [x] Service class is created with proper namespace
- [x] getVisibleProductsForConsumer returns only visible products
- [x] getVisibleProductsForInstitution returns only visible products
- [x] getAllProductsForSeller returns all products for a seller
- [x] checkVisibilityAfterStockChange returns visibility status

**Testing:**
- Create unit tests for the service
- Mock Menu::visibleForPublic() scope

---

#### 2.2 Create StockChangeListener

**Description:** Create an event listener to handle stock change events for logging and future notifications.

**Implementation Details:**
- Create `app/Listeners/StockChangeListener.php`
- Implement `handle($event)` method
- Log stock changes with product info

**File:** `app/Listeners/StockChangeListener.php`

**Acceptance Criteria:**
- [x] Listener handles Menu model events
- [x] Logs stock changes with product_id and new_stock
- [x] Handles null product gracefully

**Testing:**
- Test listener with stock update events
- Verify logging output

---

#### 2.3 Update EventServiceProvider

**Description:** Register the StockChangeListener in the EventServiceProvider.

**Implementation Details:**
- Add listener to `protected $listen` array
- Register for `eloquent.updating: App\Models\Menu` event
- Register for `eloquent.created: App\Models\Menu` event

**File:** `app/Providers/EventServiceProvider.php`

**Acceptance Criteria:**
- [x] EventServiceProvider includes StockChangeListener
- [x] Listener is registered for Menu model events

**Testing:**
- Run `php artisan event:list` to verify registration

---

### Phase 3: Controller Integration

#### 3.1 Update Consumer dashboard controller

**Description:** Update the consumer dashboard controller to use ProductVisibilityService.

**Implementation Details:**
- Inject ProductVisibilityService in the controller
- Use `getVisibleProductsForConsumer()` method
- Keep existing view return structure

**File:** `app/Http/Controllers/MenuController.php` (or consumer-specific controller)

**Acceptance Criteria:**
- [x] Consumer dashboard shows only visible products
- [x] Products with stock = 0 are not shown
- [~] Products from closed stores are shown with "Tutup" status

**Testing:**
- Access consumer dashboard
- Verify products are filtered correctly

---

#### 3.2 Update Institution dashboard controller

**Description:** Update the institution dashboard controller to use ProductVisibilityService.

**Implementation Details:**
- Inject ProductVisibilityService in the controller
- Use `getVisibleProductsForInstitution()` method
- Keep existing view return structure

**File:** `app/Http/Controllers/MenuController.php` (or institution-specific controller)

**Acceptance Criteria:**
- [x] Institution dashboard shows only visible products
- [ ] Products with stock = 0 are not shown
- [ ] Products from closed stores are shown with "Tutup" status

**Testing:**
- Access institution dashboard
- Verify products are filtered correctly

---

### Phase 4: View Updates

#### 4.1 Add status badge to product display

**Description:** Add status badge display to product cards in consumer and institution views.

**Implementation Details:**
- Add status badge using `$product->display_status`
- Show "Tutup" badge for products from closed stores
- Show "Habis" badge for products with stock = 0 (if visible)
- Style consistently with existing badges

**Files to modify:**
- `resources/views/consumer/dashboard.blade.php` (or equivalent)
- `resources/views/institution/dashboard.blade.php` (or equivalent)

**Acceptance Criteria:**
- [x] Status badge is displayed on each product card
- [x] Badge color matches status (secondary for Tutup, danger for Habis, success for Tersedia)
- [x] View remains backward compatible

**Testing:**
- View consumer dashboard
- View institution dashboard
- Verify badge display

---

### Phase 5: Verification and Testing

#### 5.1 Run full test suite

**Description:** Run all tests to ensure no regressions.

**Implementation Details:**
- Run `php artisan test`
- Verify all existing tests pass
- Add new tests for the feature

**Acceptance Criteria:**
- [x] All existing tests pass
- [x] New tests for scopes pass
- [x] New tests for service pass
- [x] No regressions in existing functionality

---

#### 5.2 Manual testing

**Description:** Perform manual testing of all scenarios.

**Test Scenarios:**
1. Seller closes store → Check consumer dashboard shows "Tutup" status
2. Seller opens store → Check consumer dashboard shows "Buka" status
3. Seller sets product stock to 0 → Check product disappears from consumer dashboard
4. Seller increases stock from 0 → Check product appears in consumer dashboard
5. Institution dashboard behaves same as consumer dashboard
6. Seller dashboard still shows all products including out-of-stock

**Acceptance Criteria:**
- [x] All 6 scenarios work as expected
- [x] No console errors
- [x] UI displays correctly

---

## Dependencies

```
1.1 → 2.1 (Service uses Menu model scopes)
1.2 → 2.1 (Service uses User model accessors)
2.1 → 3.1 (Controller uses service)
2.1 → 3.2 (Controller uses service)
3.1 → 4.1 (View uses model accessors)
3.2 → 4.1 (View uses model accessors)
4.1 → 5.2 (View changes need manual testing)
5.1 → 5.2 (Tests should pass before manual testing)
```

## Estimated Effort

- Phase 1: 2-3 hours
- Phase 2: 2-3 hours
- Phase 3: 1-2 hours
- Phase 4: 1-2 hours
- Phase 5: 2-3 hours

**Total: 8-13 hours**

## Notes

- All changes are additive - no existing code should be modified
- Use Laravel's dependency injection for services
- Follow existing code style and conventions
- Add comments for new code sections
- Update database indexes if needed for performance
## Task Dependency Graph

```json
{
  "waves": [
    { "id": 0, "tasks": ["1.1", "1.2"] },
    { "id": 1, "tasks": ["2.1"] },
    { "id": 2, "tasks": ["2.2", "2.3"] },
    { "id": 3, "tasks": ["3.1", "3.2"] },
    { "id": 4, "tasks": ["4.1"] },
    { "id": 5, "tasks": ["5.1", "5.2"] }
  ]
}
```