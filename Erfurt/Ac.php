<?php
abstract class Erfurt_Ac
{
    /**
     * Constant for permission deny
     */
    const ACCESS_PERM_DENY          = 'deny';

    /**
     * Constant for permission grant
     */
    const ACCESS_PERM_GRANT         = 'grant';

    /**
     * Constant for permission type edit
     */
    const ACCESS_TYPE_EDIT          = 'edit';

    /**
     * Constant for permission type view
     */
    const ACCESS_TYPE_VIEW          = 'view';

    /**
     * Constant with URI for standardized login action
     */
    const ACTION_LOGIN              = 'http://ns.ontowiki.net/SysOnt/Login';

    /**
     * Constant with URI for standardized register action
     */

    const ACTION_REGISTER           = 'http://ns.ontowiki.net/SysOnt/RegisterNewUser';

    /**
     * Constant for stating that any action is allowed by user.
     */
    const AC_ANY_ACTION_ALLOWED     = 'userAnyActionAllowed';

    /**
     * Constant for stating that any model view is allowed by user.
     */
    const AC_ANY_MODEL_EDIT_ALLOWED = 'userAnyModelViewAllowed';

    /**
     * Constant for stating that any model edit is allowed by user.
     */
    const AC_ANY_MODEL_VIEW_ALLOWED = 'userAnyModelEditAllowed';

    /**
     * Constant for deny access
     */
    const AC_DENY_ACCESS            = 'denyAccess';

    /**
     * Constant for grant access 
     */
    const AC_GRANT_ACCESS           = 'grantAccess';

    /**
     * Constant for stating that model edit is denied for user.
     */
    const AC_DENY_MODEL_EDIT        = 'denyModelEdit';

    /**
     * Constant for stating that model view is denied for user.
     */
    const AC_DENY_MODEL_VIEW        = 'denyModelView';

    /**
     * Constant for stating that model edit is allowed by user.
     */
    const AC_GRANT_MODEL_EDIT       = 'grantModelEdit';

    /**
     * Constant for stating that model view is allowed by user.
     */
    const AC_GRANT_MODEL_VIEW       = 'grantModelView';

    /**
     * The user that is used for asserting ac rights.
     *
     * If no user is explicitly set (e.g. by auth component) the anonymous user is used within this
     * class.
     *
     * @var Erfurt_Auth_Identity
     */
    private $_user = null;

    /**
     * Adds a right to a model for the current user.
     * 
     * @param string $modelUri The URI of the model
     * @param string $type Type of access: Erfurt_Ac::ACCESS_TYPE_VIEW or Erfurt_Ac::ACCESS_TYPE_EDIT
     * @param string $perm Type of permission: Erfurt_Ac::ACCESS_PERM_GRANT or Erfurt_Ac::ACCESS_PERM_DENY
     * @throws Erfurt_Ac_Exception Throws an exception if wrong type or permission was provided
     * @return bool Returns true on success
     */
    abstract public function addUserModelRule($modelUri, $type = Erfurt_Ac::ACCESS_TYPE_VIEW, $perm = Erfurt_Ac::ACCESS_PERM_GRANT);

    /**
     * Delivers the action configuration for a given action if it exists.
     *
     * If the given action does not exist this method returns false. By default the first parameter
     * to this method is a URI identifying an action. This behaviour can be overwritten by providing
     * false for the seconds parameter.
     * 
     * @param string $action The URI or label of the action
     * @param bool $isUri Whether the fiven action is an URI or not
     * @return array|bool Returns an array with the action spec or false if not found
     */
    abstract public function getActionConfig($action, $isUri = true);

    /**
     * Checks whether the given action is allowed for the current user.
     *
     * If the given action does not exist this method returns false. By default the first parameter
     * to this method is a URI identifying an action. This behaviour can be overwritten by providing
     * false for the seconds parameter.
     *
     * @param string $action The URI or label of the action
     * @param bool $isUri Whether the fiven action is an URI or not
     * @return bool Returns whether action is allowed or not
     */
    abstract public function isActionAllowed($action, $isUri = true);

    /**
     * Checks whether any action is allowed for the current user.
     *
     * @return boolean Returns whether any action is allowed or not
     */
    abstract public function isAnyActionAllowed();

    /**
     * Checks whether the current user has the given permission type for any model.
     *
     * @param string $type Either Erfurt_Ac::ACCESS_TYPE_VIEW or Erfurt_Ac::ACCESS_TYPE_EDIT
     * @return bool Returns true when allowed and false otherwise
     */
    abstract public function isAnyModelAllowed($type = Erfurt_Ac::ACCESS_TYPE_VIEW);

    /**
     * Checks whether the given permission type is allowed for the current user on the given model uri.
     *
     * @param string $type Either Erfurt_Ac::ACCESS_TYPE_VIEW or Erfurt_Ac::ACCESS_TYPE_EDIT
     * @param string $modelUri The URI of the model to check
     * @return bool Returns true when allowed and false otherwise
     */
    abstract public function isModelAllowed($type, $modelUri);

    /**
     * Returns the active user.
     *
     * If no user was set before by calling setUser, this method returns the anonymous user.
     *
     * @return Erfurt_Auth_Identity
     */
    public function getUser()
    {
        if (null !== $this->_user) {
            return $this->_user;
        }

        $identityObject = new Erfurt_Auth_Identity(array(
            'username'  => 'Anonymous',
            'uri'       => Erfurt_Auth::ANONYMOUS_USER,
            'anonymous' => true,
            'dbuser'    => false,
            'email'     => ''
        ));

        return $identityObject;
    }

    /**
     * Sets the active user that is used for asserting access rights.
     *
     * @param Erfurt_Auth_Identity $user If you provide null the anonymous user is used
     * @return void
     */
    public function setUser(Erfurt_Auth_Identity $user = null)
    {
        $this->_user = $user;
    }
}
