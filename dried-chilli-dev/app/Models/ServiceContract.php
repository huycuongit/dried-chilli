<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Support\WebsiteContractTemplate;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ServiceContract extends Model
{
    protected $fillable = [
        'website_details', 'created_by', 'public_token', 'contract_number', 'title', 'status', 'locale',
        'effective_date', 'expires_at', 'provider_name', 'provider_legal_name',
        'provider_tax_id', 'provider_email', 'provider_phone', 'provider_address',
        'customer_name', 'customer_company', 'customer_email', 'customer_phone',
        'customer_tax_id', 'customer_address', 'scope_summary', 'terms', 'payment_terms',
        'subtotal', 'tax_rate', 'tax_amount', 'total', 'currency', 'sent_at',
        'viewed_at', 'signed_at', 'signature_name', 'signature_data', 'signature_ip',
        'signature_user_agent', 'signature_consent', 'signed_payload_hash',
    ];

    protected $casts = [
        'website_details' => 'array',
        'effective_date' => 'date',
        'expires_at' => 'date',
        'sent_at' => 'datetime',
        'viewed_at' => 'datetime',
        'signed_at' => 'datetime',
        'signature_consent' => 'boolean',
        'subtotal' => 'decimal:2',
        'tax_rate' => 'decimal:2',
        'tax_amount' => 'decimal:2',
        'total' => 'decimal:2',
    ];

    public function resolvedText(?string $text): string
    {
        return WebsiteContractTemplate::resolve($text, $this->website_details ?? [],
            $this->effective_date ? $this->effective_date->format('d/m/Y') : 'ngày ký');
    }

    public function hasUnfilledTerms(): bool
    {
        return WebsiteContractTemplate::incomplete(
            $this->resolvedText($this->terms . "\n" . $this->payment_terms . "\n" . $this->scope_summary),
            $this->website_details,
            config('website-contract.fields')
        );
    }

    public function items(): HasMany
    {
        return $this->hasMany(ServiceContractItem::class)->orderBy('position');
    }

    public function isSigned(): bool
    {
        return $this->status === 'signed' || $this->signed_at !== null;
    }

    public function publicUrl(): string
    {
        return route('contracts.show', $this->public_token);
    }
}
