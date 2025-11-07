<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * ╔══════════════════════════════════════════════════════════════╗
 * ║                                                              ║
 * ║              💰 FINANCIAL RECORD MODEL 💰                    ║
 * ║                                                              ║
 * ║  Elegant data management for your financial transactions    ║
 * ║  Track income, expenses, and everything in between          ║
 * ║                                                              ║
 * ╚══════════════════════════════════════════════════════════════╝
 */

class FinancialRecord extends Model
{
    use HasFactory;

    // ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
    //  ✨ Fillable Attributes - Your Financial Data Fields
    // ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
    
    protected $fillable = [
        'user_id',           // 👤 User identifier
        'type',              // 📊 Transaction type (income/expense)
        'amount',            // 💵 Transaction amount
        'title',             // 📝 Transaction title
        'description',       // 📄 Detailed description
        'category',          // 🏷️ Category tag
        'image_path',        // 🖼️ Receipt or proof image
        'transaction_date'   // 📅 When it happened
    ];

    // ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
    //  🔗 Relationships - Connecting Your Data
    // ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
    //  🎯 Type Casting - Smart Data Formatting
    // ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
    
    protected $casts = [
        'transaction_date' => 'date',      // 📆 Auto-format dates
        'amount' => 'decimal:2'            // 💰 Precise money handling
    ];
}

// ═══════════════════════════════════════════════════════════════
//  Made with ❤️ for better financial management
// ═══════════════════════════════════════════════════════════════