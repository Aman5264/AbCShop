<?php

namespace App\Services;

use App\Models\Product;
use App\Models\Faq;
use App\Models\Category;

class AIContextService
{
    /**
     * Get the restricted system prompt for the AI.
     */
    public function getSystemPrompt(): string
    {
        return "You are the ABC Shop Virtual Assistant. Your ONLY purpose is to assist customers with products, orders, and store information related to ABC Shop.

STRICT RULES:
1. If a user asks anything unrelated to ABC Shop (e.g., general knowledge, coding, politics, math, or personal advice), politely decline and state: \"I am the ABC Shop Assistant, and I am only trained to help with shop-related queries. How can I help you with our products today?\"
2. Use the provided product and FAQ context to answer accurately.
3. Be professional, friendly, and concise.
4. If you don't know the answer based on the context, ask the user to contact support at support@abcshop.com.";
    }

    /**
     * Aggregate business data for AI context.
     */
    public function getStoreContext(): string
    {
        $products = Product::where('is_active', true)
            ->limit(20) // Limit to avoid hitting token limits
            ->get(['name', 'description', 'price', 'sale_price', 'sale_start_date', 'sale_end_date'])
            ->map(function ($p) {
                $price = $p->is_on_sale ? $p->sale_price : $p->price;
                return "- {$p->name}: ₹{$price}. {$p->description}";
            })->implode("\n");

        $faqs = Faq::limit(10)
            ->get(['question', 'answer'])
            ->map(function ($f) {
                return "Q: {$f->question}\nA: {$f->answer}";
            })->implode("\n\n");

        return "--- STORE CONTEXT ---\n\nAVAILABLE PRODUCTS:\n{$products}\n\nFREQUENTLY ASKED QUESTIONS:\n{$faqs}\n\n--- END CONTEXT ---";
    }
}
