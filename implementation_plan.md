# Master Implementation Plan: E-Commerce Feature Expansion

This plan outlines the implementation of 13 new features for the shop application, structured into 4 logical phases to maintain stability and deliver value incrementally.

## Phase 1: Essential User Experience (Quick Wins)
Focus on features that immediately improve the shopping experience and product discovery.

### 1. Wishlist System
- **Database**: Create `wishlists` table (user_id, product_id).
- **Backend**: `WishlistController` (toggle, index).
- **Frontend**: Heart icon on Product Card/Page. "My Wishlist" page in Profile.

### 2. Product Reviews & Ratings
- **Database**: Create `reviews` table (user_id, product_id, rating, comment, is_approved).
- **Admin**: Filament Resource for moderating reviews.
- **Frontend**: Star rating component. Review form on Product Show page.

### 3. Related Products
- **Logic**: Update `ShopController@show` to fetch 4 products from the same Category or Tags.
- **Frontend**: "You May Also Like" carousel/grid section on Product Show page.

---

## Phase 2: Checkout & Order Management
Focus on reducing checkout friction and post-purchase transparency.

### 4. User Address Book
- **Database**: Create `addresses` table (user_id, type, line1, city, state, zip, phone).
- **Frontend**: Profile section to manage addresses. Checkout selection (radio buttons) to auto-fill fields.

### System Architecture

### 1. AI Engine (Gemini API)
- **Model**: `gemini-1.5-flash` (Optimized for speed and cost).
- **Security**: API key will be stored in `.env` as `GEMINI_API_KEY`.
- **Scoping Logic**: 
    - The AI will be provided with a strict **System Prompt** defining its identity as the "ABC Shop Assistant".
    - It will be explicitly instructed to **refuse** any questions not related to the shop, products, or order status.
    - **Context Injection (RAG)**: The backend will inject the current product catalog, store policies, and FAQ content into every request to ensure high accuracy.

### 2. Backend Implementation
**Files**:
- `app/Http/Controllers/ChatController.php`: Receives user messages, fetches context, calls Gemini API, and returns the response.
- `app/Services/AIContextService.php` [NEW]:
    - `getStoreContext()`: Fetches active products, categories, and FAQ data.
    - `getSystemPrompt()`: Returns the detailed persona and restriction instructions.

### 3. Frontend UI (ABC Shop Style)
**File**: `resources/views/components/chat-widget.blade.php` [NEW]
- **Floating Bubble**: Bottom-right floating button with "ABC Shop" branding.
- **Glassmorphism Window**: Slide-up chat interface matching the shop's premium design.
- **Real-time Feel**: Alpine.js for smooth messaging and "AI is typing" animations.

## Content Restriction Strategy
To ensure the AI strictly answers business-only queries, the system prompt will include:
> "You are the ABC Shop Virtual Assistant. Your ONLY purpose is to assist customers with products, orders, and store information. If a user asks a question unrelated to ABC Shop (e.g., general knowledge, coding, politics, or other businesses), politely decline and state that you are only here to help with ABC Shop matters."

## Settings Configuration
- `ai_chatbot_active`: Master toggle.
- `gemini_api_key`: Stored in `.env`.
- `ai_search_boost`: Optional toggle to prioritize specific products.

### 5. Discount Coupons
- **Database**: Create `coupons` table (code, type, value, expiry_date, usage_limit).
- **Admin**: Filament Resource for Coupon management.
- **Backend**: Logic in `CartController`/`PaymentController` to validate and apply discount.
- **Frontend**: "Enter Coupon" input in Cart and Checkout summary.

### 6. Order Tracking Page
- **Route**: Public route `/track-order`.
- **Frontend**: Simple form (Order Number + Email). Result page showing current Status and Timeline.

---

## Phase 3: Marketing & Engagement
Focus on retaining customers and recovering lost sales.

### 7. Newsletter Subscription
- **Database**: `subscribers` table (email, is_active).
- **Frontend**: Footer component + Popup integration.
- **Admin**: Simple list of subscribers (exportable).

### 8. Social Login (Socialite)
- **Tech**: Laravel Socialite.
- **Config**: Setup Google/Facebook Client IDs.
- **Frontend**: "Login with Google" buttons on Login/Register pages.

### 9. Flash Sales
- **Database**: Add `sale_price`, `sale_start`, `sale_end` to `products` (or separate table).
- **Frontend**: Countdown timer component. Badge "Ends in X hours".

### 10. Abandoned Cart Recovery
- **Logic**: Scheduled Job (`daily`) to find carts updated > 1 hour ago but not ordered.
- **Email**: Send generic "You forgot something" email.

---

## Phase 4: Content & Support
Focus on SEO and Customer Support.

### 11. Blog / News Section
- **Database**: `posts` table (title, slug, content, image, published_at).
- **Admin**: Filament Resource (RichEditor).
- **Frontend**: `/blog` index and `/blog/{slug}` show pages.

### 12. FAQ / Help Center
- **Database**: `faqs` table (question, answer, category, order).
- **Admin**: Filament Resource.
- **Frontend**: Accordion UI on `/faq` page.

### 13. Live Chat Integration
- **Frontend**: Inject script (e.g., Tawk.to or WhatsApp widget) into `app.blade.php`.
- **Config**: Allow enable/disable via Admin Settings.

---

## Next Steps
We will begin with **Phase 1**.
1. Create `wishlists` migration.
2. Develop Wishlist Controller & Routes.
3. specific UI integration.
