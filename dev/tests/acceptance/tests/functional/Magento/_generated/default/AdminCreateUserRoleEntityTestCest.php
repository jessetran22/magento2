<?php
namespace Magento\AcceptanceTest\_default\Backend;

use Magento\FunctionalTestingFramework\AcceptanceTester;
use \Codeception\Util\Locator;
use Yandex\Allure\Adapter\Annotation\Features;
use Yandex\Allure\Adapter\Annotation\Stories;
use Yandex\Allure\Adapter\Annotation\Title;
use Yandex\Allure\Adapter\Annotation\Description;
use Yandex\Allure\Adapter\Annotation\Parameter;
use Yandex\Allure\Adapter\Annotation\Severity;
use Yandex\Allure\Adapter\Model\SeverityLevel;
use Yandex\Allure\Adapter\Annotation\TestCaseId;

/**
 * @Title("MC-14258: Creating a new role with different data sets")
 * @Description("Creating a new role with different data sets<h3>Test files</h3>app/code/Magento/User/Test/Mftf/Test/AdminCreateUserRoleEntityTest.xml<br>")
 * @TestCaseId("MC-14258")
 * @group user
 * @group mtf_migrated
 */
class AdminCreateUserRoleEntityTestCest
{
    /**
     * @var \Magento\FunctionalTestingFramework\Helper\HelperContainer
     */
    private $helperContainer;

    /**
     * Special method which automatically creates the respective objects.
     */
    public function _inject(\Magento\FunctionalTestingFramework\Helper\HelperContainer $helperContainer)
    {
        $this->helperContainer = $helperContainer;
        $this->helperContainer->create("Magento\Catalog\Test\Mftf\Helper\LocalFileAssertions");
        $this->helperContainer->create("\Magento\Catalog\Test\Mftf\Helper\LocalFileAssertions");
        $this->helperContainer->create("\Magento\Backend\Test\Mftf\Helper\CurlHelpers");
        $this->helperContainer->create("Magento\Rule\Test\Mftf\Helper\RuleHelper");
    }
	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _before(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [logIn] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLogIn
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLogIn
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLogIn
		$I->click(".actions .action-primary"); // stepKey: clickLoginLogIn
		$I->waitForPageLoad(30); // stepKey: clickLoginLogInWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLogIn
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLogIn
		$I->comment("Exiting Action Group [logIn] AdminLoginActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [logOut] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogOut
		$I->comment("Exiting Action Group [logOut] AdminLogoutActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _failed(AcceptanceTester $I)
	{
		$I->saveScreenshot(); // stepKey: saveScreenshot
	}

	/**
	 * @Features({"User"})
	 * @Stories({"Create User Role"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminCreateUserRoleEntityTest(AcceptanceTester $I)
	{
		$I->comment("Create a new role with custom access");
		$I->comment("Entering Action Group [goToNewRolePage] AdminOpenCreateRolePageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/user_role/editrole"); // stepKey: amOnNewAdminRolePageGoToNewRolePage
		$I->waitForPageLoad(30); // stepKey: waitForNewAdminRolePageLoadGoToNewRolePage
		$I->comment("Exiting Action Group [goToNewRolePage] AdminOpenCreateRolePageActionGroup");
		$I->comment("Entering Action Group [fillNewRoleForm] AdminFillUserRoleFormActionGroup");
		$I->fillField("#role_name", "Role Sales " . msq("roleSales")); // stepKey: fillRoleNameFillNewRoleForm
		$I->fillField("#current_password", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillCurrentUserPasswordFillNewRoleForm
		$I->click("#role_info_tabs_account"); // stepKey: clickToOpenRoleResourcesFillNewRoleForm
		$I->waitForPageLoad(30); // stepKey: clickToOpenRoleResourcesFillNewRoleFormWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForRoleResourceTabFillNewRoleForm
		$I->selectOption("[data-ui-id='adminhtml-user-editroles-tab-content-account'] [name='all']", "Custom"); // stepKey: selectResourceAccessFillNewRoleForm
		$I->comment("TODO waiting for custom action functionality with MQE-1964");
		$I->comment("<performOn stepKey=\"checkNeededResources\" selector=\"\{\{AdminCreateRoleSection.resourceTree\}\}\" function=\"function(\$I,\$userRoles=\{\{role.resource\}\})\{foreach(\$userRoles as \$userRole)\{\$I->conditionalClick('//li[@data-id=\'' . \$userRole . '\']//*[@class=\'jstree-checkbox\']','//li[@data-id=\'' . \$userRole . '\' and contains(@class, \'jstree-checked\')]',false);\}\}\" />");
		$I->comment("Exiting Action Group [fillNewRoleForm] AdminFillUserRoleFormActionGroup");
		$I->comment("Entering Action Group [saveNewRole] AdminClickSaveButtonOnUserRoleFormActionGroup");
		$I->click("//button[@title='Save Role']"); // stepKey: saveRoleSaveNewRole
		$I->waitForPageLoad(30); // stepKey: saveRoleSaveNewRoleWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForSaveResultLoadSaveNewRole
		$I->comment("Exiting Action Group [saveNewRole] AdminClickSaveButtonOnUserRoleFormActionGroup");
		$I->comment("Entering Action Group [assertSuccessMessage] AssertMessageInAdminPanelActionGroup");
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitForMessageVisibleAssertSuccessMessage
		$I->see("You saved the role.", "#messages div.message-success"); // stepKey: verifyMessageAssertSuccessMessage
		$I->comment("Exiting Action Group [assertSuccessMessage] AssertMessageInAdminPanelActionGroup");
		$I->comment("Entering Action Group [assertRoleInGrid] AssertAdminRoleInGridActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/user_role/"); // stepKey: navigateToRolesGridAssertRoleInGrid
		$I->fillField("#roleGrid_filter_role_name", "Role Sales " . msq("roleSales")); // stepKey: enterRoleNameAssertRoleInGrid
		$I->click(".admin__data-grid-header button[title=Search]"); // stepKey: clickSearchAssertRoleInGrid
		$I->waitForPageLoad(15); // stepKey: waitForGridToLoadAssertRoleInGrid
		$I->see("Role Sales " . msq("roleSales"), ".col-role_name"); // stepKey: seeTheRoleAssertRoleInGrid
		$I->comment("Exiting Action Group [assertRoleInGrid] AssertAdminRoleInGridActionGroup");
		$I->comment("Delete the new role with custom access");
		$I->comment("Entering Action Group [deleteSaleRole] AdminDeleteUserRoleActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/user_role/"); // stepKey: navigateToUserRolesGridDeleteSaleRole
		$I->fillField("#roleGrid_filter_role_name", "Role Sales " . msq("roleSales")); // stepKey: enterRoleNameDeleteSaleRole
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickSearchDeleteSaleRole
		$I->waitForPageLoad(30); // stepKey: clickSearchDeleteSaleRoleWaitForPageLoad
		$I->see("Role Sales " . msq("roleSales"), "table.data-grid tbody > tr:nth-of-type(1)"); // stepKey: seeUserRoleDeleteSaleRole
		$I->click("table.data-grid tbody > tr:nth-of-type(1)"); // stepKey: openRoleEditPageDeleteSaleRole
		$I->waitForPageLoad(30); // stepKey: waitForRoleEditPageLoadDeleteSaleRole
		$I->fillField("#current_password", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: enterThePasswordDeleteSaleRole
		$I->click("button[title='Delete Role']"); // stepKey: deleteUserRoleDeleteSaleRole
		$I->waitForElementVisible("aside.confirm .modal-content", 30); // stepKey: waitForConfirmModalDeleteSaleRole
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: confirmDeleteDeleteSaleRole
		$I->waitForPageLoad(60); // stepKey: confirmDeleteDeleteSaleRoleWaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitSuccessMessageDeleteSaleRole
		$I->see("You deleted the role.", "#messages div.message-success"); // stepKey: seeUserRoleDeleteMessageDeleteSaleRole
		$I->comment("Exiting Action Group [deleteSaleRole] AdminDeleteUserRoleActionGroup");
		$I->comment("Create a new role with full access");
		$I->comment("Entering Action Group [goToNewRolePageSecondTime] AdminOpenCreateRolePageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/user_role/editrole"); // stepKey: amOnNewAdminRolePageGoToNewRolePageSecondTime
		$I->waitForPageLoad(30); // stepKey: waitForNewAdminRolePageLoadGoToNewRolePageSecondTime
		$I->comment("Exiting Action Group [goToNewRolePageSecondTime] AdminOpenCreateRolePageActionGroup");
		$I->comment("Entering Action Group [fillNewRoleFormSecondTime] AdminFillUserRoleFormActionGroup");
		$I->fillField("#role_name", "Administrator " . msq("roleAdministrator")); // stepKey: fillRoleNameFillNewRoleFormSecondTime
		$I->fillField("#current_password", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillCurrentUserPasswordFillNewRoleFormSecondTime
		$I->click("#role_info_tabs_account"); // stepKey: clickToOpenRoleResourcesFillNewRoleFormSecondTime
		$I->waitForPageLoad(30); // stepKey: clickToOpenRoleResourcesFillNewRoleFormSecondTimeWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForRoleResourceTabFillNewRoleFormSecondTime
		$I->selectOption("[data-ui-id='adminhtml-user-editroles-tab-content-account'] [name='all']", "All"); // stepKey: selectResourceAccessFillNewRoleFormSecondTime
		$I->comment("TODO waiting for custom action functionality with MQE-1964");
		$I->comment("<performOn stepKey=\"checkNeededResources\" selector=\"\{\{AdminCreateRoleSection.resourceTree\}\}\" function=\"function(\$I,\$userRoles=\{\{role.resource\}\})\{foreach(\$userRoles as \$userRole)\{\$I->conditionalClick('//li[@data-id=\'' . \$userRole . '\']//*[@class=\'jstree-checkbox\']','//li[@data-id=\'' . \$userRole . '\' and contains(@class, \'jstree-checked\')]',false);\}\}\" />");
		$I->comment("Exiting Action Group [fillNewRoleFormSecondTime] AdminFillUserRoleFormActionGroup");
		$I->comment("Entering Action Group [saveNewRoleSecondTime] AdminClickSaveButtonOnUserRoleFormActionGroup");
		$I->click("//button[@title='Save Role']"); // stepKey: saveRoleSaveNewRoleSecondTime
		$I->waitForPageLoad(30); // stepKey: saveRoleSaveNewRoleSecondTimeWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForSaveResultLoadSaveNewRoleSecondTime
		$I->comment("Exiting Action Group [saveNewRoleSecondTime] AdminClickSaveButtonOnUserRoleFormActionGroup");
		$I->comment("Entering Action Group [assertSuccessMessageSecondTime] AssertMessageInAdminPanelActionGroup");
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitForMessageVisibleAssertSuccessMessageSecondTime
		$I->see("You saved the role.", "#messages div.message-success"); // stepKey: verifyMessageAssertSuccessMessageSecondTime
		$I->comment("Exiting Action Group [assertSuccessMessageSecondTime] AssertMessageInAdminPanelActionGroup");
		$I->comment("Entering Action Group [assertRoleInGridSecondTime] AssertAdminRoleInGridActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/user_role/"); // stepKey: navigateToRolesGridAssertRoleInGridSecondTime
		$I->fillField("#roleGrid_filter_role_name", "Administrator " . msq("roleAdministrator")); // stepKey: enterRoleNameAssertRoleInGridSecondTime
		$I->click(".admin__data-grid-header button[title=Search]"); // stepKey: clickSearchAssertRoleInGridSecondTime
		$I->waitForPageLoad(15); // stepKey: waitForGridToLoadAssertRoleInGridSecondTime
		$I->see("Administrator " . msq("roleAdministrator"), ".col-role_name"); // stepKey: seeTheRoleAssertRoleInGridSecondTime
		$I->comment("Exiting Action Group [assertRoleInGridSecondTime] AssertAdminRoleInGridActionGroup");
		$I->comment("Delete the new role with full access");
		$I->comment("Entering Action Group [deleteAdministratorRole] AdminDeleteUserRoleActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/user_role/"); // stepKey: navigateToUserRolesGridDeleteAdministratorRole
		$I->fillField("#roleGrid_filter_role_name", "Administrator " . msq("roleAdministrator")); // stepKey: enterRoleNameDeleteAdministratorRole
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickSearchDeleteAdministratorRole
		$I->waitForPageLoad(30); // stepKey: clickSearchDeleteAdministratorRoleWaitForPageLoad
		$I->see("Administrator " . msq("roleAdministrator"), "table.data-grid tbody > tr:nth-of-type(1)"); // stepKey: seeUserRoleDeleteAdministratorRole
		$I->click("table.data-grid tbody > tr:nth-of-type(1)"); // stepKey: openRoleEditPageDeleteAdministratorRole
		$I->waitForPageLoad(30); // stepKey: waitForRoleEditPageLoadDeleteAdministratorRole
		$I->fillField("#current_password", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: enterThePasswordDeleteAdministratorRole
		$I->click("button[title='Delete Role']"); // stepKey: deleteUserRoleDeleteAdministratorRole
		$I->waitForElementVisible("aside.confirm .modal-content", 30); // stepKey: waitForConfirmModalDeleteAdministratorRole
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: confirmDeleteDeleteAdministratorRole
		$I->waitForPageLoad(60); // stepKey: confirmDeleteDeleteAdministratorRoleWaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitSuccessMessageDeleteAdministratorRole
		$I->see("You deleted the role.", "#messages div.message-success"); // stepKey: seeUserRoleDeleteMessageDeleteAdministratorRole
		$I->comment("Exiting Action Group [deleteAdministratorRole] AdminDeleteUserRoleActionGroup");
		$I->comment("Create a new role using incorrect current_password");
		$I->comment("Entering Action Group [goToNewRolePageThirdTime] AdminOpenCreateRolePageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/user_role/editrole"); // stepKey: amOnNewAdminRolePageGoToNewRolePageThirdTime
		$I->waitForPageLoad(30); // stepKey: waitForNewAdminRolePageLoadGoToNewRolePageThirdTime
		$I->comment("Exiting Action Group [goToNewRolePageThirdTime] AdminOpenCreateRolePageActionGroup");
		$I->comment("Entering Action Group [fillNewRoleFormThirdTime] AdminFillUserRoleFormActionGroup");
		$I->fillField("#role_name", "Administrator " . msq("roleAdministrator")); // stepKey: fillRoleNameFillNewRoleFormThirdTime
		$I->fillField("#current_password", getenv("MAGENTO_ADMIN_PASSWORD") . "INVALID"); // stepKey: fillCurrentUserPasswordFillNewRoleFormThirdTime
		$I->click("#role_info_tabs_account"); // stepKey: clickToOpenRoleResourcesFillNewRoleFormThirdTime
		$I->waitForPageLoad(30); // stepKey: clickToOpenRoleResourcesFillNewRoleFormThirdTimeWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForRoleResourceTabFillNewRoleFormThirdTime
		$I->selectOption("[data-ui-id='adminhtml-user-editroles-tab-content-account'] [name='all']", "All"); // stepKey: selectResourceAccessFillNewRoleFormThirdTime
		$I->comment("TODO waiting for custom action functionality with MQE-1964");
		$I->comment("<performOn stepKey=\"checkNeededResources\" selector=\"\{\{AdminCreateRoleSection.resourceTree\}\}\" function=\"function(\$I,\$userRoles=\{\{role.resource\}\})\{foreach(\$userRoles as \$userRole)\{\$I->conditionalClick('//li[@data-id=\'' . \$userRole . '\']//*[@class=\'jstree-checkbox\']','//li[@data-id=\'' . \$userRole . '\' and contains(@class, \'jstree-checked\')]',false);\}\}\" />");
		$I->comment("Exiting Action Group [fillNewRoleFormThirdTime] AdminFillUserRoleFormActionGroup");
		$I->comment("Entering Action Group [saveNewRoleThirdTime] AdminClickSaveButtonOnUserRoleFormActionGroup");
		$I->click("//button[@title='Save Role']"); // stepKey: saveRoleSaveNewRoleThirdTime
		$I->waitForPageLoad(30); // stepKey: saveRoleSaveNewRoleThirdTimeWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForSaveResultLoadSaveNewRoleThirdTime
		$I->comment("Exiting Action Group [saveNewRoleThirdTime] AdminClickSaveButtonOnUserRoleFormActionGroup");
		$I->comment("Entering Action Group [assertErrorMessage] AssertMessageInAdminPanelActionGroup");
		$I->waitForElementVisible("#messages div.message-error", 30); // stepKey: waitForMessageVisibleAssertErrorMessage
		$I->see("The password entered for the current user is invalid. Verify the password and try again.", "#messages div.message-error"); // stepKey: verifyMessageAssertErrorMessage
		$I->comment("Exiting Action Group [assertErrorMessage] AssertMessageInAdminPanelActionGroup");
		$I->comment("Entering Action Group [assertRoleNotInGrid] AssertAdminRoleNotInGridActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/user_role/"); // stepKey: navigateToRolesGridAssertRoleNotInGrid
		$I->fillField("#roleGrid_filter_role_name", "Administrator " . msq("roleAdministrator")); // stepKey: enterRoleNameAssertRoleNotInGrid
		$I->click(".admin__data-grid-header button[title=Search]"); // stepKey: clickSearchAssertRoleNotInGrid
		$I->waitForPageLoad(15); // stepKey: waitForGridToLoadAssertRoleNotInGrid
		$I->see("We couldn't find any records.", "//tr[@class='data-grid-tr-no-data even']/td[@class='empty-text']"); // stepKey: seeEmptyRecordMessageAssertRoleNotInGrid
		$I->comment("Exiting Action Group [assertRoleNotInGrid] AssertAdminRoleNotInGridActionGroup");
	}
}
