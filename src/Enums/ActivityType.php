<?php

namespace Msaaq\Nelc\Enums;

enum ActivityType: string
{
    /**
     * A unit test in a test suite that is part of a programming project.
     */
    case UNIT_TEST = 'http://id.tincanapi.com/activitytype/unit-test';

    /**
     * A lesson is learning content that may or may not take on the form of a SCO (formal, tracked learning).
     * A lesson may stand alone or may be part of a larger course.
     */
    case LESSON = 'http://adlnet.gov/expapi/activities/lesson';

    /**
     * A course represents an amount of content that is published and registered into with the purpose of gaining completion.
     * It is represented with a Course Structure Format in cmi5 as the highest level of content (above Block and AU).
     */
    case COURSE = 'https://w3id.org/xapi/cmi5/activitytype/course';

    /**
     * A recording of both the visual and audible components made available on a display screen.
     */
    case VIDEO = 'https://w3id.org/xapi/video/activity-type/video';

    /**
     * A module represents any “content aggregation” at least one level below the course level.
     * Modules of modules can exist for layering purposes. Modules are not content. Modules are one level up from all content.
     */
    case MODULE = 'http://adlnet.gov/expapi/activities/module';

    /**
     * A document attesting to the fact that a person has completed an educational course.
     */
    case CERTIFICATE = 'https://www.opigno.org/en/tincan_registry/activity_type/certificate';
}
