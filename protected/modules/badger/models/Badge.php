<?php
/*

    Yes, you can change this file (actually you MUST do that)
    1) Add constants of badges in 3-word format BADGE_{GROUP}_{NAME} = 'badge-slug'
        BADGE_COMMENT_FIRST = 'comment-1'
        BADGE_COMMENT_5 = 'comment-fifth'
        BADGE_COMMENT_1000 = 'comment-1000'

    2) In this format because you will be able to check whole badge group:
        BADGE_COMMENT_*
        $Badge->checkAndGiveGroup('comment'); // as you like
        $Badge->checkAndGiveGroup('Comment'); // as you like
        $Badge->checkAndGiveGroup('COMMENT'); // as you like

        and it will check all badges under this (comment) group.

    3) To check one badge
        $Badge->checkAndGiveOne( Badge::BADGE_LOGIN_FIRST );
        $Badge->checkAndGiveOne( Badge::BADGE_COMMENT_5 );


*/

class Badge extends BadgeParent
{
    // Sync manualy badge constants with database
    // Images must be as badge slug:
    //          modules/badge/assets/images/login-first.png

    # Login
    const BADGE_LOGIN_FIRST = 'login-first';

    # Viewer
    const BADGE_LIST_MY = 'list-my';

    # Comments
    //const BADGE_COMMENT_FIRST = 'comment-1';
    //const BADGE_COMMENT_5 = 'comment-fifth';
    //const BADGE_COMMENT_1000 = 'comment-1000';



    # Your badge logic (this function check only one badge)
    #   already checked $slug variable (or it's bug)
    #   no return required
    #   status saved to $this->success
    #
    # DON'T USE THIS FUNCTION DIRECTLY IN YOUR CODE (it will do nothing)
    # ==================================================================
    public function check( $slug ) {

        switch( $slug ) {

                  # Login
                  # ---------------------------------------------------------------------
                  case self::BADGE_LOGIN_FIRST :
                        # do your specific check to award or not
                        // $canUserHaveBadge = (2 + 2) == 4;
                        // $this->success = $canUserhaveBadge;

                        # or just give him this badge (without checking anything)
                        $this->success = true;
                  break;

                  # Viewer
                  # ---------------------------------------------------------------------
                  case self::BADGE_LIST_MY :
                        $this->success = true;
                  break;

                  # Comment
                  # Example to give badge based on user comment count
                  # ---------------------------------------------------------------------
                  //case self::BADGE_COMMENT_FIRST :
                  //      $this->success = Comment::model()->my()->count() >= 1;
                  //break;
                  //case self::BADGE_COMMENT_5 :
                  //      $this->success = Comment::model()->my()->count() >= 5;
                  //break;
                  //case self::BADGE_COMMENT_1000 :
                  //      $this->success = Comment::model()->my()->count() >= 1000;
                  //break;

        }

    }

}
