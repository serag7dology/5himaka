<?php

namespace Spatie\SchemaOrg;

use \Spatie\SchemaOrg\Contracts\ActionContract;
use \Spatie\SchemaOrg\Contracts\AssessActionContract;
use \Spatie\SchemaOrg\Contracts\ChooseActionContract;
use \Spatie\SchemaOrg\Contracts\ThingContract;

/**
 * The act of expressing a preference from a fixed/finite/structured set of
 * choices/options.
 *
 * @see http://schema.org/VoteAction
 *
 */
class VoteAction extends BaseType implements ActionContract, AssessActionContract, ChooseActionContract, ThingContract
{
    /**
     * A sub property of object. The options subject to this action.
     *
     * @param Thing|Thing[]|string|string[] $actionOption
     *
     * @return static
     *
     * @see http://schema.org/actionOption
     */
    public function actionOption($actionOption)
    {
        return $this->setProperty('actionOption', $actionOption);
    }

    /**
     * Indicates the current disposition of the Action.
     *
     * @param ActionStatusType|ActionStatusType[] $actionStatus
     *
     * @return static
     *
     * @see http://schema.org/actionStatus
     */
    public function actionStatus($actionStatus)
    {
        return $this->setProperty('actionStatus', $actionStatus);
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
     * The direct performer or driver of the action (animate or inanimate). e.g.
     * *John* wrote a book.
     *
     * @param Organization|Organization[]|Person|Person[] $agent
     *
     * @return static
     *
     * @see http://schema.org/agent
     */
    public function agent($agent)
    {
        return $this->setProperty('agent', $agent);
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
     * A sub property of object. The candidate subject of this action.
     *
     * @param Person|Person[] $candidate
     *
     * @return static
     *
     * @see http://schema.org/candidate
     */
    public function candidate($candidate)
    {
        return $this->setProperty('candidate', $candidate);
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
     * The endTime of something. For a reserved event or service (e.g.
     * FoodEstablishmentReservation), the time that it is expected to end. For
     * actions that span a period of time, when the action was performed. e.g.
     * John wrote a book from January to *December*. For media, including audio
     * and video, it's the time offset of the end of a clip within a larger
     * file.
     * 
     * Note that Event uses startDate/endDate instead of startTime/endTime, even
     * when describing dates with times. This situation may be clarified in
     * future revisions.
     *
     * @param \DateTimeInterface|\DateTimeInterface[] $endTime
     *
     * @return static
     *
     * @see http://schema.org/endTime
     */
    public function endTime($endTime)
    {
        return $this->setProperty('endTime', $endTime);
    }

    /**
     * For failed actions, more information on the cause of the failure.
     *
     * @param Thing|Thing[] $error
     *
     * @return static
     *
     * @see http://schema.org/error
     */
    public function error($error)
    {
        return $this->setProperty('error', $error);
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
     * The object that helped the agent perform the action. e.g. John wrote a
     * book with *a pen*.
     *
     * @param Thing|Thing[] $instrument
     *
     * @return static
     *
     * @see http://schema.org/instrument
     */
    public function instrument($instrument)
    {
        return $this->setProperty('instrument', $instrument);
    }

    /**
     * The location of for example where the event is happening, an organization
     * is located, or where an action takes place.
     *
     * @param Place|Place[]|PostalAddress|PostalAddress[]|string|string[] $location
     *
     * @return static
     *
     * @see http://schema.org/location
     */
    public function location($location)
    {
        return $this->setProperty('location', $location);
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
     * The object upon which the action is carried out, whose state is kept
     * intact or changed. Also known as the semantic roles patient, affected or
     * undergoer (which change their state) or theme (which doesn't). e.g. John
     * read *a book*.
     *
     * @param Thing|Thing[] $object
     *
     * @return static
     *
     * @see http://schema.org/object
     */
    public function object($object)
    {
        return $this->setProperty('object', $object);
    }

    /**
     * A sub property of object. The options subject to this action.
     *
     * @param Thing|Thing[]|string|string[] $option
     *
     * @return static
     *
     * @see http://schema.org/option
     */
    public function option($option)
    {
        return $this->setProperty('option', $option);
    }

    /**
     * Other co-agents that participated in the action indirectly. e.g. John
     * wrote a book with *Steve*.
     *
     * @param Organization|Organization[]|Person|Person[] $participant
     *
     * @return static
     *
     * @see http://schema.org/participant
     */
    public function participant($participant)
    {
        return $this->setProperty('participant', $participant);
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
     * The result produced in the action. e.g. John wrote *a book*.
     *
     * @param Thing|Thing[] $result
     *
     * @return static
     *
     * @see http://schema.org/result
     */
    public function result($result)
    {
        return $this->setProperty('result', $result);
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
     * The startTime of something. For a reserved event or service (e.g.
     * FoodEstablishmentReservation), the time that it is expected to start. For
     * actions that span a period of time, when the action was performed. e.g.
     * John wrote a book from *January* to December. For media, including audio
     * and video, it's the time offset of the start of a clip within a larger
     * file.
     * 
     * Note that Event uses startDate/endDate instead of startTime/endTime, even
     * when describing dates with times. This situation may be clarified in
     * future revisions.
     *
     * @param \DateTimeInterface|\DateTimeInterface[] $startTime
     *
     * @return static
     *
     * @see http://schema.org/startTime
     */
    public function startTime($startTime)
    {
        return $this->setProperty('startTime', $startTime);
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
     * Indicates a target EntryPoint for an Action.
     *
     * @param EntryPoint|EntryPoint[] $target
     *
     * @return static
     *
     * @see http://schema.org/target
     */
    public function target($target)
    {
        return $this->setProperty('target', $target);
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
