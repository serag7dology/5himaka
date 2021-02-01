<?php

namespace Spatie\SchemaOrg;

use \Spatie\SchemaOrg\Contracts\IntangibleContract;
use \Spatie\SchemaOrg\Contracts\ThingContract;

/**
 * An order is a confirmation of a transaction (a receipt), which can contain
 * multiple line items, each represented by an Offer that has been accepted by
 * the customer.
 *
 * @see http://schema.org/Order
 *
 */
class Order extends BaseType implements IntangibleContract, ThingContract
{
    /**
     * The offer(s) -- e.g., product, quantity and price combinations --
     * included in the order.
     *
     * @param Offer|Offer[] $acceptedOffer
     *
     * @return static
     *
     * @see http://schema.org/acceptedOffer
     */
    public function acceptedOffer($acceptedOffer)
    {
        return $this->setProperty('acceptedOffer', $acceptedOffer);
    }

    /**
     * An additional type for the item, typically used for adding more specific
     * types from external vocabularies in microdata syntax. This is a
     * relationship between something and a class that the thing is in. In RDFa
     * syntax, it is better to use the native RDFa syntax - the 'typeof'
     * attribute - for multiple types. Schema.org tools may have only weaker
     * understanding of extra types, in particular those defined externally.
     *
     * @param string|string[] $additionalType
     *
     * @return static
     *
     * @see http://schema.org/additionalType
     */
    public function additionalType($additionalType)
    {
        return $this->setProperty('additionalType', $additionalType);
    }

    /**
     * An alias for the item.
     *
     * @param string|string[] $alternateName
     *
     * @return static
     *
     * @see http://schema.org/alternateName
     */
    public function alternateName($alternateName)
    {
        return $this->setProperty('alternateName', $alternateName);
    }

    /**
     * The billing address for the order.
     *
     * @param PostalAddress|PostalAddress[] $billingAddress
     *
     * @return static
     *
     * @see http://schema.org/billingAddress
     */
    public function billingAddress($billingAddress)
    {
        return $this->setProperty('billingAddress', $billingAddress);
    }

    /**
     * An entity that arranges for an exchange between a buyer and a seller.  In
     * most cases a broker never acquires or releases ownership of a product or
     * service involved in an exchange.  If it is not clear whether an entity is
     * a broker, seller, or buyer, the latter two terms are preferred.
     *
     * @param Organization|Organization[]|Person|Person[] $broker
     *
     * @return static
     *
     * @see http://schema.org/broker
     */
    public function broker($broker)
    {
        return $this->setProperty('broker', $broker);
    }

    /**
     * A number that confirms the given order or payment has been received.
     *
     * @param string|string[] $confirmationNumber
     *
     * @return static
     *
     * @see http://schema.org/confirmationNumber
     */
    public function confirmationNumber($confirmationNumber)
    {
        return $this->setProperty('confirmationNumber', $confirmationNumber);
    }

    /**
     * Party placing the order or paying the invoice.
     *
     * @param Organization|Organization[]|Person|Person[] $customer
     *
     * @return static
     *
     * @see http://schema.org/customer
     */
    public function customer($customer)
    {
        return $this->setProperty('customer', $customer);
    }

    /**
     * A description of the item.
     *
     * @param string|string[] $description
     *
     * @return static
     *
     * @see http://schema.org/description
     */
    public function description($description)
    {
        return $this->setProperty('description', $description);
    }

    /**
     * A sub property of description. A short description of the item used to
     * disambiguate from other, similar items. Information from other properties
     * (in particular, name) may be necessary for the description to be useful
     * for disambiguation.
     *
     * @param string|string[] $disambiguatingDescription
     *
     * @return static
     *
     * @see http://schema.org/disambiguatingDescription
     */
    public function disambiguatingDescription($disambiguatingDescription)
    {
        return $this->setProperty('disambiguatingDescription', $disambiguatingDescription);
    }

    /**
     * Any discount applied (to an Order).
     *
     * @param float|float[]|int|int[]|string|string[] $discount
     *
     * @return static
     *
     * @see http://schema.org/discount
     */
    public function discount($discount)
    {
        return $this->setProperty('discount', $discount);
    }

    /**
     * Code used to redeem a discount.
     *
     * @param string|string[] $discountCode
     *
     * @return static
     *
     * @see http://schema.org/discountCode
     */
    public function discountCode($discountCode)
    {
        return $this->setProperty('discountCode', $discountCode);
    }

    /**
     * The currency of the discount.
     * 
     * Use standard formats: [ISO 4217 currency
     * format](http://en.wikipedia.org/wiki/ISO_4217) e.g. "USD"; [Ticker
     * symbol](https://en.wikipedia.org/wiki/List_of_cryptocurrencies) for
     * cryptocurrencies e.g. "BTC"; well known names for [Local Exchange
     * Tradings
     * Systems](https://en.wikipedia.org/wiki/Local_exchange_trading_system)
     * (LETS) and other currency types e.g. "Ithaca HOUR".
     *
     * @param string|string[] $discountCurrency
     *
     * @return static
     *
     * @see http://schema.org/discountCurrency
     */
    public function discountCurrency($discountCurrency)
    {
        return $this->setProperty('discountCurrency', $discountCurrency);
    }

    /**
     * The identifier property represents any kind of identifier for any kind of
     * [[Thing]], such as ISBNs, GTIN codes, UUIDs etc. Schema.org provides
     * dedicated properties for representing many of these, either as textual
     * strings or as URL (URI) links. See [background
     * notes](/docs/datamodel.html#identifierBg) for more details.
     *
     * @param PropertyValue|PropertyValue[]|string|string[] $identifier
     *
     * @return static
     *
     * @see http://schema.org/identifier
     */
    public function identifier($identifier)
    {
        return $this->setProperty('identifier', $identifier);
    }

    /**
     * An image of the item. This can be a [[URL]] or a fully described
     * [[ImageObject]].
     *
     * @param ImageObject|ImageObject[]|string|string[] $image
     *
     * @return static
     *
     * @see http://schema.org/image
     */
    public function image($image)
    {
        return $this->setProperty('image', $image);
    }

    /**
     * Was the offer accepted as a gift for someone other than the buyer.
     *
     * @param bool|bool[] $isGift
     *
     * @return static
     *
     * @see http://schema.org/isGift
     */
    public function isGift($isGift)
    {
        return $this->setProperty('isGift', $isGift);
    }

    /**
     * Indicates a page (or other CreativeWork) for which this thing is the main
     * entity being described. See [background
     * notes](/docs/datamodel.html#mainEntityBackground) for details.
     *
     * @param CreativeWork|CreativeWork[]|string|string[] $mainEntityOfPage
     *
     * @return static
     *
     * @see http://schema.org/mainEntityOfPage
     */
    public function mainEntityOfPage($mainEntityOfPage)
    {
        return $this->setProperty('mainEntityOfPage', $mainEntityOfPage);
    }

    /**
     * 'merchant' is an out-dated term for 'seller'.
     *
     * @param Organization|Organization[]|Person|Person[] $merchant
     *
     * @return static
     *
     * @see http://schema.org/merchant
     */
    public function merchant($merchant)
    {
        return $this->setProperty('merchant', $merchant);
    }

    /**
     * The name of the item.
     *
     * @param string|string[] $name
     *
     * @return static
     *
     * @see http://schema.org/name
     */
    public function name($name)
    {
        return $this->setProperty('name', $name);
    }

    /**
     * Date order was placed.
     *
     * @param \DateTimeInterface|\DateTimeInterface[] $orderDate
     *
     * @return static
     *
     * @see http://schema.org/orderDate
     */
    public function orderDate($orderDate)
    {
        return $this->setProperty('orderDate', $orderDate);
    }

    /**
     * The delivery of the parcel related to this order or order item.
     *
     * @param ParcelDelivery|ParcelDelivery[] $orderDelivery
     *
     * @return static
     *
     * @see http://schema.org/orderDelivery
     */
    public function orderDelivery($orderDelivery)
    {
        return $this->setProperty('orderDelivery', $orderDelivery);
    }

    /**
     * The identifier of the transaction.
     *
     * @param string|string[] $orderNumber
     *
     * @return static
     *
     * @see http://schema.org/orderNumber
     */
    public function orderNumber($orderNumber)
    {
        return $this->setProperty('orderNumber', $orderNumber);
    }

    /**
     * The current status of the order.
     *
     * @param OrderStatus|OrderStatus[] $orderStatus
     *
     * @return static
     *
     * @see http://schema.org/orderStatus
     */
    public function orderStatus($orderStatus)
    {
        return $this->setProperty('orderStatus', $orderStatus);
    }

    /**
     * The item ordered.
     *
     * @param OrderItem|OrderItem[]|Product|Product[]|Service|Service[] $orderedItem
     *
     * @return static
     *
     * @see http://schema.org/orderedItem
     */
    public function orderedItem($orderedItem)
    {
        return $this->setProperty('orderedItem', $orderedItem);
    }

    /**
     * The order is being paid as part of the referenced Invoice.
     *
     * @param Invoice|Invoice[] $partOfInvoice
     *
     * @return static
     *
     * @see http://schema.org/partOfInvoice
     */
    public function partOfInvoice($partOfInvoice)
    {
        return $this->setProperty('partOfInvoice', $partOfInvoice);
    }

    /**
     * The date that payment is due.
     *
     * @param \DateTimeInterface|\DateTimeInterface[] $paymentDue
     *
     * @return static
     *
     * @see http://schema.org/paymentDue
     */
    public function paymentDue($paymentDue)
    {
        return $this->setProperty('paymentDue', $paymentDue);
    }

    /**
     * The date that payment is due.
     *
     * @param \DateTimeInterface|\DateTimeInterface[] $paymentDueDate
     *
     * @return static
     *
     * @see http://schema.org/paymentDueDate
     */
    public function paymentDueDate($paymentDueDate)
    {
        return $this->setProperty('paymentDueDate', $paymentDueDate);
    }

    /**
     * The name of the credit card or other method of payment for the order.
     *
     * @param PaymentMethod|PaymentMethod[] $paymentMethod
     *
     * @return static
     *
     * @see http://schema.org/paymentMethod
     */
    public function paymentMethod($paymentMethod)
    {
        return $this->setProperty('paymentMethod', $paymentMethod);
    }

    /**
     * An identifier for the method of payment used (e.g. the last 4 digits of
     * the credit card).
     *
     * @param string|string[] $paymentMethodId
     *
     * @return static
     *
     * @see http://schema.org/paymentMethodId
     */
    public function paymentMethodId($paymentMethodId)
    {
        return $this->setProperty('paymentMethodId', $paymentMethodId);
    }

    /**
     * The URL for sending a payment.
     *
     * @param string|string[] $paymentUrl
     *
     * @return static
     *
     * @see http://schema.org/paymentUrl
     */
    public function paymentUrl($paymentUrl)
    {
        return $this->setProperty('paymentUrl', $paymentUrl);
    }

    /**
     * Indicates a potential Action, which describes an idealized action in
     * which this thing would play an 'object' role.
     *
     * @param Action|Action[] $potentialAction
     *
     * @return static
     *
     * @see http://schema.org/potentialAction
     */
    public function potentialAction($potentialAction)
    {
        return $this->setProperty('potentialAction', $potentialAction);
    }

    /**
     * URL of a reference Web page that unambiguously indicates the item's
     * identity. E.g. the URL of the item's Wikipedia page, Wikidata entry, or
     * official website.
     *
     * @param string|string[] $sameAs
     *
     * @return static
     *
     * @see http://schema.org/sameAs
     */
    public function sameAs($sameAs)
    {
        return $this->setProperty('sameAs', $sameAs);
    }

    /**
     * An entity which offers (sells / leases / lends / loans) the services /
     * goods.  A seller may also be a provider.
     *
     * @param Organization|Organization[]|Person|Person[] $seller
     *
     * @return static
     *
     * @see http://schema.org/seller
     */
    public function seller($seller)
    {
        return $this->setProperty('seller', $seller);
    }

    /**
     * A CreativeWork or Event about this Thing.
     *
     * @param CreativeWork|CreativeWork[]|Event|Event[] $subjectOf
     *
     * @return static
     *
     * @see http://schema.org/subjectOf
     */
    public function subjectOf($subjectOf)
    {
        return $this->setProperty('subjectOf', $subjectOf);
    }

    /**
     * URL of the item.
     *
     * @param string|string[] $url
     *
     * @return static
     *
     * @see http://schema.org/url
     */
    public function url($url)
    {
        return $this->setProperty('url', $url);
    }

}
