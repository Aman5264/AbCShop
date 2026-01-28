-- ABC Shop Data Export
SET FOREIGN_KEY_CHECKS = 0;

-- Data for users
INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `is_active`, `role`, `last_login_at`, `google_id`, `avatar`) VALUES ('1', 'Test User', 'test@example.com', '2026-01-21 12:18:24', '$2y$12$4ZYlEdS/tuzPMOTpg8eBKul4MeFKjLS4uZfuf9qZTdDqkDLRGlkBK', 'tSaSr4XPveSqOrtVmUFHfF0IamVlGiIy2M9J9xRFzH722q5ZyPHSdZjp1op6', '2026-01-21 12:18:24', '2026-01-21 12:18:24', '1', 'customer', NULL, NULL, NULL);
INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `is_active`, `role`, `last_login_at`, `google_id`, `avatar`) VALUES ('2', 'Admin User', 'admin@example.com', '2026-01-21 12:18:24', '$2y$12$jKwmTm82qB5fyZSoKctj5u4PGTkpyI6/RFlpYHGcFutG5M.Ci/BC2', 'VJO0sncta2Nfz9Zx9ZjXKoTWsEyAFXnygr6deueLt9BV4l2vdGNrojR3posH', '2026-01-21 12:18:24', '2026-01-21 12:18:24', '1', 'customer', NULL, NULL, NULL);

-- Data for roles
INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES ('1', 'admin', 'web', '2026-01-21 12:18:23', '2026-01-21 12:18:23');
INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES ('2', 'manager', 'web', '2026-01-21 12:18:23', '2026-01-21 12:18:23');
INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES ('3', 'staff', 'web', '2026-01-21 12:18:23', '2026-01-21 12:18:23');
INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES ('4', 'customer', 'web', '2026-01-21 12:18:23', '2026-01-21 12:18:23');

-- Data for permissions
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES ('1', 'view_dashboard', 'web', '2026-01-21 12:18:23', '2026-01-21 12:18:23');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES ('2', 'manage_users', 'web', '2026-01-21 12:18:23', '2026-01-21 12:18:23');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES ('3', 'manage_products', 'web', '2026-01-21 12:18:23', '2026-01-21 12:18:23');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES ('4', 'manage_orders', 'web', '2026-01-21 12:18:23', '2026-01-21 12:18:23');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES ('5', 'manage_settings', 'web', '2026-01-21 12:18:23', '2026-01-21 12:18:23');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES ('6', 'view_reports', 'web', '2026-01-21 12:18:23', '2026-01-21 12:18:23');

-- Data for model_has_roles
INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES ('1', 'App\Models\User', '2');

-- Data for role_has_permissions
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES ('1', '1');
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES ('2', '1');
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES ('3', '1');
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES ('4', '1');
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES ('5', '1');
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES ('6', '1');

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES ('1', '2');
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES ('3', '2');
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES ('4', '2');
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES ('6', '2');
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES ('1', '3');
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES ('4', '3');

-- Data for categories
INSERT INTO `categories` (`id`, `name`, `slug`, `description`, `image`, `parent_id`, `created_at`, `updated_at`) VALUES ('1', 'Electronics', 'electronics', 'Gadgets and devices', 'https://images.unsplash.com/photo-1550009158-9ebf69173e03?auto=format&fit=crop&w=200&q=80', NULL, '2026-01-21 12:18:23', '2026-01-21 12:18:23');
INSERT INTO `categories` (`id`, `name`, `slug`, `description`, `image`, `parent_id`, `created_at`, `updated_at`) VALUES ('2', 'Clothing', 'clothing', 'Apparel for all', 'https://images.unsplash.com/photo-1523381210434-271e8be1f52b?auto=format&fit=crop&w=200&q=80', NULL, '2026-01-21 12:18:23', '2026-01-21 12:18:23');
INSERT INTO `categories` (`id`, `name`, `slug`, `description`, `image`, `parent_id`, `created_at`, `updated_at`) VALUES ('3', 'Home & Garden', 'home-garden', 'Decor and tools', 'https://images.unsplash.com/photo-1616046229478-9901c5536a45?auto=format&fit=crop&w=200&q=80', NULL, '2026-01-21 12:18:23', '2026-01-21 12:18:23');
INSERT INTO `categories` (`id`, `name`, `slug`, `description`, `image`, `parent_id`, `created_at`, `updated_at`) VALUES ('4', 'Laptops', 'laptops', NULL, 'https://images.unsplash.com/photo-1496181133206-80ce9b88a853?auto=format&fit=crop&w=200&q=80', '1', '2026-01-21 12:18:23', '2026-01-21 12:18:23');
INSERT INTO `categories` (`id`, `name`, `slug`, `description`, `image`, `parent_id`, `created_at`, `updated_at`) VALUES ('5', 'Smartphones', 'smartphones', NULL, 'https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?auto=format&fit=crop&w=200&q=80', '1', '2026-01-21 12:18:23', '2026-01-21 12:18:23');
INSERT INTO `categories` (`id`, `name`, `slug`, `description`, `image`, `parent_id`, `created_at`, `updated_at`) VALUES ('6', 'Shirts', 'shirts', NULL, 'https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?auto=format&fit=crop&w=200&q=80', '2', '2026-01-21 12:18:23', '2026-01-21 12:18:23');

-- Data for products
INSERT INTO `products` (`id`, `name`, `description`, `price`, `image_url`, `created_at`, `updated_at`, `stock`, `is_active`, `status`, `is_featured`, `sku`, `barcode`, `cost_price`, `security_stock`, `sale_price`, `sale_start_date`, `sale_end_date`) VALUES ('1', 'MacBook Pro', '<p>Powerful laptop for professionals.</p>', '5001999.99', 'https://images.unsplash.com/photo-1517336714731-489689fd1ca8', '2026-01-21 12:18:23', '2026-01-24 22:42:22', '8', '1', 'draft', '0', 'hiwiii', 'euiwued', NULL, '10', '1000', '2026-01-24 00:00:00', '2026-01-27 00:00:00');
INSERT INTO `products` (`id`, `name`, `description`, `price`, `image_url`, `created_at`, `updated_at`, `stock`, `is_active`, `status`, `is_featured`, `sku`, `barcode`, `cost_price`, `security_stock`, `sale_price`, `sale_start_date`, `sale_end_date`) VALUES ('2', 'iPhone 15', 'The latest smartphone from Apple.', '999.99', 'https://images.unsplash.com/photo-1695048133142-1a20484d2569', '2026-01-21 12:18:23', '2026-01-24 20:51:31', '19', '1', 'draft', '0', NULL, NULL, NULL, '10', NULL, NULL, NULL);
INSERT INTO `products` (`id`, `name`, `description`, `price`, `image_url`, `created_at`, `updated_at`, `stock`, `is_active`, `status`, `is_featured`, `sku`, `barcode`, `cost_price`, `security_stock`, `sale_price`, `sale_start_date`, `sale_end_date`) VALUES ('3', 'Samsung Galaxy S24', 'Android flagship with AI features.', '899.99', 'https://images.unsplash.com/photo-1610945415295-d9bbf067e59c', '2026-01-21 12:18:23', '2026-01-21 12:18:23', '15', '1', 'draft', '0', NULL, NULL, NULL, '10', NULL, NULL, NULL);
INSERT INTO `products` (`id`, `name`, `description`, `price`, `image_url`, `created_at`, `updated_at`, `stock`, `is_active`, `status`, `is_featured`, `sku`, `barcode`, `cost_price`, `security_stock`, `sale_price`, `sale_start_date`, `sale_end_date`) VALUES ('4', 'Classic White T-Shirt', '100% Cotton, comfortable fit.', '19.99', 'https://images.unsplash.com/photo-1521572163474-6864f9cf17ab', '2026-01-21 12:18:23', '2026-01-22 12:18:06', '49', '1', 'draft', '0', NULL, NULL, NULL, '10', NULL, NULL, NULL);
INSERT INTO `products` (`id`, `name`, `description`, `price`, `image_url`, `created_at`, `updated_at`, `stock`, `is_active`, `status`, `is_featured`, `sku`, `barcode`, `cost_price`, `security_stock`, `sale_price`, `sale_start_date`, `sale_end_date`) VALUES ('5', 'Modern Sofa', 'Comfortable 3-seater sofa.', '499', 'https://images.unsplash.com/photo-1555041469-a586c61ea9bc', '2026-01-21 12:18:24', '2026-01-24 20:51:31', '2', '1', 'draft', '0', NULL, NULL, NULL, '10', NULL, NULL, NULL);

-- Data for pages
INSERT INTO `pages` (`id`, `title`, `slug`, `content`, `is_active`, `meta_title`, `meta_description`, `created_at`, `updated_at`, `status`, `published_at`, `created_by`, `updated_by`, `deleted_at`, `custom_css`, `custom_html`) VALUES ('1', 'About Us', 'about-us', '<p><figure data-trix-attachment="{&quot;contentType&quot;:&quot;image/jpeg&quot;,&quot;filename&quot;:&quot;shopping-cart-with-gift-and-confetti-for-online-shop-vector.jpg&quot;,&quot;filesize&quot;:19231,&quot;height&quot;:350,&quot;href&quot;:&quot;http://localhost:8000/storage/nByg35XJmYCUI3donHLzFIX0ezM5ZxfoIEGFGGtC.jpg&quot;,&quot;url&quot;:&quot;http://localhost:8000/storage/nByg35XJmYCUI3donHLzFIX0ezM5ZxfoIEGFGGtC.jpg&quot;,&quot;width&quot;:584}" data-trix-content-type="image/jpeg" data-trix-attributes="{&quot;caption&quot;:&quot;.&quot;,&quot;presentation&quot;:&quot;gallery&quot;}" class="attachment attachment--preview attachment--jpg"><a href="http://localhost:8000/storage/nByg35XJmYCUI3donHLzFIX0ezM5ZxfoIEGFGGtC.jpg"><img src="http://localhost:8000/storage/nByg35XJmYCUI3donHLzFIX0ezM5ZxfoIEGFGGtC.jpg" width="584" height="350"><figcaption class="attachment__caption attachment__caption--edited">.</figcaption></a></figure></p>', '1', 'ABCShop – Online Shopping for Quality Products at Best Prices', 'Shop online at ABCShop for high-quality products at affordable prices. Enjoy secure payments, fast delivery, easy returns, and 24/7 customer support.', '2026-01-27 10:01:48', '2026-01-27 16:34:09', 'published', '2026-01-27 13:22:04', '2', '2', NULL, '* {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: ''Segoe UI'', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background-color: #f9fafb;
            color: #333;
            line-height: 1.6;
        }

        .container {
            max-width: 1100px;
            margin: 0 auto;
            padding: 40px 20px;
        }

        .page-title {
            text-align: center;
            font-size: 36px;
            font-weight: 700;
            margin-bottom: 40px;
            color: #111827;
        }

        .section {
            margin-bottom: 50px;
            background: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
        }

        .section h2 {
            font-size: 24px;
            margin-bottom: 15px;
            color: #1f2937;
        }

        .section p {
            margin-bottom: 15px;
            color: #4b5563;
        }

        .mission-quote {
            font-style: italic;
            background: #f3f4f6;
            padding: 15px;
            border-left: 4px solid #2563eb;
            margin-bottom: 20px;
        }

        .features-list {
            list-style: none;
            padding-left: 0;
        }

        .features-list li {
            margin-bottom: 10px;
            padding-left: 25px;
            position: relative;
        }

        .features-list li::before {
            content: "✔";
            position: absolute;
            left: 0;
            color: #16a34a;
            font-weight: bold;
        }

        .contact-info {
            margin-top: 10px;
        }

        .contact-info p {
            margin-bottom: 8px;
            font-weight: 500;
        }

        @media (max-width: 768px) {
            .page-title {
                font-size: 28px;
            }

            .section {
                padding: 20px;
            }

            .section h2 {
                font-size: 20px;
            }
        }
/* This centers the "About Us" title */
h1 {
    text-align: center;
}

/* This centers the image you just added and any text */
.prose {
    text-align: center;
}

.prose img {
    margin: 0 auto;
    display: block;
}
/* Hide image filename and file size */
.attachment__metadata {
    display: none !important;
}

/* If you also want to center everything, keep this: */
h1, .prose { 
    text-align: center; 
}

.prose img { 
    margin: 0 auto; 
}', '﻿

.
﻿

</head>
<body>

    <div class="container">

        

        <div class="section">
            <h2>Who We Are</h2>
            <p>Welcome to <strong>ABCShop</strong> — your one-stop destination for quality products at unbeatable prices.</p>
            <p>At ABCShop, we believe shopping should be simple, affordable, and enjoyable. Our platform connects customers with a wide range of carefully selected products, delivered right to their doorstep with speed and reliability.</p>
            <p>We are more than just an online store — we are a growing community of smart shoppers who value quality, transparency, and convenience.</p>
        </div>

        <div class="section">
            <h2>Our Mission</h2>
            <div class="mission-quote">
                To provide high-quality products at competitive prices while delivering a seamless and secure shopping experience.
            </div>
            <ul class="features-list">
                <li>Easy product discovery</li>
                <li>Secure payment options</li>
                <li>Fast delivery</li>
                <li>Reliable customer support</li>
            </ul>
        </div>

        <div class="section">
            <h2>Why Choose ABCShop?</h2>
            <ul class="features-list">
                <li>Wide Range of Products</li>
                <li>Affordable & Transparent Pricing</li>
                <li>Secure Payment Gateway</li>
                <li>Easy Returns & Refund Policy</li>
                <li>24/7 Customer Support</li>
            </ul>
            <p>We focus on customer satisfaction first — because your trust is our biggest achievement.</p>
        </div>

        <div class="section">
            <h2>Our Vision</h2>
            <p>We aspire to become one of the most trusted eCommerce platforms by continuously improving our services, expanding our product categories, and embracing the latest technology to enhance user experience.</p>
            <p>ABCShop is built with passion, innovation, and commitment to excellence.</p>
        </div>

        <div class="section">
            <h2>Customer First Approach</h2>
            <p>At ABCShop, every decision we make revolves around our customers. From product selection to checkout experience, everything is designed to make your shopping journey smooth and enjoyable.</p>
            <p>Your satisfaction is not just our goal — it’s our promise.</p>
        </div>

        <div class="section">
            <h2>Get in Touch</h2>
            <div class="contact-info">
                <p>Email: support@abcshop.com</p>
                <p>Serving customers nationwide</p>
            </div>
        </div>

    </div>

</body>');

-- Data for banners
INSERT INTO `banners` (`id`, `title`, `image_url`, `link`, `description`, `sort_order`, `is_active`, `created_at`, `updated_at`) VALUES ('1', 'ab', 'banners/01KFJY7JN3KAADCP8CG06FAJ1R.png', 'https://www.google.com', 'abcd', '1', '1', '2026-01-22 13:27:49', '2026-01-27 18:03:16');
INSERT INTO `banners` (`id`, `title`, `image_url`, `link`, `description`, `sort_order`, `is_active`, `created_at`, `updated_at`) VALUES ('2', 'shop now', 'banners/01KFZDYGTTX64MQNG9PP12D5F1.jpg', 'https://www.google.com', NULL, '2', '1', '2026-01-27 09:53:23', '2026-01-27 10:12:24');

-- Data for settings
INSERT INTO `settings` (`id`, `key`, `value`, `group`, `type`, `created_at`, `updated_at`) VALUES ('1', 'whatsapp_number', '+916207188317', 'integration', 'text', '2026-01-25 18:07:04', '2026-01-25 18:09:36');
INSERT INTO `settings` (`id`, `key`, `value`, `group`, `type`, `created_at`, `updated_at`) VALUES ('2', 'live_chat_script', '', 'integration', 'text', '2026-01-25 18:07:04', '2026-01-25 18:07:04');
INSERT INTO `settings` (`id`, `key`, `value`, `group`, `type`, `created_at`, `updated_at`) VALUES ('3', 'live_chat_active', '1', 'integration', 'boolean', '2026-01-25 18:07:04', '2026-01-25 18:08:29');

-- Data for wishlists
INSERT INTO `wishlists` (`id`, `user_id`, `product_id`, `created_at`, `updated_at`) VALUES ('1', '1', '1', '2026-01-24 19:34:22', '2026-01-24 19:34:22');

-- Data for reviews
INSERT INTO `reviews` (`id`, `user_id`, `product_id`, `rating`, `comment`, `is_approved`, `created_at`, `updated_at`) VALUES ('1', '1', '1', '4', 'abcd', '1', '2026-01-24 19:35:00', '2026-01-24 21:53:34');

-- Data for newsletter_subscribers
INSERT INTO `newsletter_subscribers` (`id`, `email`, `is_active`, `created_at`, `updated_at`) VALUES ('1', 'yadavharsh545@outlook.com', '1', '2026-01-24 23:01:12', '2026-01-24 23:01:12');
INSERT INTO `newsletter_subscribers` (`id`, `email`, `is_active`, `created_at`, `updated_at`) VALUES ('2', 'amnsinghsheikhpura@gmail.com', '1', '2026-01-25 14:38:02', '2026-01-25 14:38:02');
INSERT INTO `newsletter_subscribers` (`id`, `email`, `is_active`, `created_at`, `updated_at`) VALUES ('3', 'admin@gmail.com', '1', '2026-01-25 18:27:05', '2026-01-25 18:27:05');


SET FOREIGN_KEY_CHECKS = 1;
