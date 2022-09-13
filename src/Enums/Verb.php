<?php

namespace Msaaq\Nelc\Enums;

enum Verb: string
{
    /**
     * Indicates the actor is officially enrolled or inducted in an activity.
     */
    case REGISTERED = 'http://adlnet.gov/expapi/verbs/registered';

    /**
     * Indicates the activity provider has determined that the actor successfully started an activity.
     */
    case INITIALIZED = 'http://adlnet.gov/expapi/verbs/initialized';

    /**
     * Indicates that the actor has watched the object.
     * This verb is typically applicable only when the object represents dynamic, visible content such as a movie,
     * a television show or a public performance.
     * This verb is a more specific form of the verbs experience, play and consume.
     */
    case WATCHED = 'https://w3id.org/xapi/acrossx/verbs/watched';

    /**
     * Indicates the actor finished or concluded the activity normally.
     */
    case COMPLETED = 'http://adlnet.gov/expapi/verbs/completed';

    /**
     * Indicates a value of how much of an actor has advanced or moved through an activity.
     */
    case PROGRESSED = 'http://adlnet.gov/expapi/verbs/progressed';

    /**
     * Action of giving a rating to an object.
     * Should only be used when the action is the rating itself,
     * as opposed to another action such as "reading" where a rating can be applied to the object as part of that action.
     * In general the rating should be included in the Result with a Score object.
     */
    case RATED = 'http://id.tincanapi.com/verb/rated';

    /**
     * Indicates that the actor has earned or has been awarded the object.
     */
    case EARNED = 'http://id.tincanapi.com/verb/earned';

    /**
     * Indicates the actor made an effort to access the object.
     * An attempt statement without additional activities could be considered incomplete in some cases.
     */
    case ATTEMPTED = 'http://adlnet.gov/expapi/verbs/attempted';
}
