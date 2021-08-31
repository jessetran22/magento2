<?php
namespace Magento\AcceptanceTest\_MediaGalleryUiSuite\Backend;

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
 * @Title("https://app.hiptest.com/projects/131313/test-plan/folders/943908/scenarios/3218882: User manages ACL rules for Media Gallery delete assets functionality")
 * @Description("User manages ACL rules for Media Gallery delete assets functionality<h3>Test files</h3>app/code/Magento/MediaGalleryUi/Test/Mftf/Test/AdminMediaGalleryDeleteAssetsAclTest.xml<br>")
 * @TestCaseId("https://app.hiptest.com/projects/131313/test-plan/folders/943908/scenarios/3218882")
 * @group media_gallery_ui
 */
class AdminMediaGalleryDeleteAssetsAclTestCest
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
        $this->helperContainer->create("Magento\MediaGalleryUi\Test\Mftf\Helper\MediaGalleryUiHelper");
    }
	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _before(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [loginAsAdminBefore] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdminBefore
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdminBefore
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdminBefore
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdminBefore
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdminBeforeWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdminBefore
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdminBefore
		$I->comment("Exiting Action Group [loginAsAdminBefore] AdminLoginActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [loginAsAdminAfter] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdminAfter
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdminAfter
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdminAfter
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdminAfter
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdminAfterWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdminAfter
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdminAfter
		$I->comment("Exiting Action Group [loginAsAdminAfter] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/user_role/"); // stepKey: navigateToUserRoleGrid
		$I->waitForPageLoad(30); // stepKey: waitForRolesGridLoad
		$I->comment("Entering Action Group [deleteUserRole] AdminDeleteRoleActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/user_role/"); // stepKey: navigateToUserRoleGridDeleteUserRole
		$I->waitForPageLoad(30); // stepKey: waitForRolesGridLoadDeleteUserRole
		$I->click("button[title='Reset Filter']"); // stepKey: clickResetFilterButtonBeforeDeleteUserRole
		$I->waitForPageLoad(10); // stepKey: waitForRolesGridFilterResetBeforeDeleteUserRole
		$I->fillField("#roleGrid_filter_role_name", "adminRole" . msq("adminRole")); // stepKey: TypeRoleFilterDeleteUserRole
		$I->waitForElementVisible(".admin__data-grid-header button[title=Search]", 10); // stepKey: waitForFilterSearchButtonBeforeDeleteUserRole
		$I->click(".admin__data-grid-header button[title=Search]"); // stepKey: clickFilterSearchButtonDeleteUserRole
		$I->waitForPageLoad(10); // stepKey: waitForUserRoleFilterDeleteUserRole
		$I->waitForElementVisible("//td[contains(@class,'col-role_name') and contains(text(), 'adminRole" . msq("adminRole") . "')]", 10); // stepKey: waitForRoleInRoleGridDeleteUserRole
		$I->click("//td[contains(@class,'col-role_name') and contains(text(), 'adminRole" . msq("adminRole") . "')]"); // stepKey: clickOnRoleDeleteUserRole
		$I->waitForPageLoad(10); // stepKey: waitForRolePageToLoadDeleteUserRole
		$I->fillField("#current_password", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: TypeCurrentPasswordDeleteUserRole
		$I->waitForElementVisible("//button/span[contains(text(), 'Delete Role')]", 10); // stepKey: waitForDeleteRoleButtonDeleteUserRole
		$I->click("//button/span[contains(text(), 'Delete Role')]"); // stepKey: clickToDeleteRoleDeleteUserRole
		$I->waitForPageLoad(5); // stepKey: waitForDeleteConfirmationPopupDeleteUserRole
		$I->waitForElementVisible("//*[@class='action-primary action-accept']", 10); // stepKey: waitForConfirmButtonDeleteUserRole
		$I->click("//*[@class='action-primary action-accept']"); // stepKey: clickToConfirmDeleteUserRole
		$I->waitForPageLoad(10); // stepKey: waitForPageLoadDeleteUserRole
		$I->see("You deleted the role."); // stepKey: seeSuccessMessageDeleteUserRole
		$I->waitForPageLoad(30); // stepKey: waitForRolesGridLoadAfterDeleteDeleteUserRole
		$I->waitForElementVisible("button[title='Reset Filter']", 10); // stepKey: waitForResetFilterButtonAfterDeleteUserRole
		$I->click("button[title='Reset Filter']"); // stepKey: clickResetFilterButtonAfterDeleteUserRole
		$I->waitForPageLoad(10); // stepKey: waitForRolesGridFilterResetAfterDeleteUserRole
		$I->comment("Exiting Action Group [deleteUserRole] AdminDeleteRoleActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/user/"); // stepKey: goToAllUsersPage
		$I->waitForPageLoad(30); // stepKey: waitForUsersGridLoad
		$I->comment("Entering Action Group [deleteUser] AdminDeleteNewUserActionGroup");
		$I->click("//td[contains(text(), 'admin" . msq("admin2") . "')]"); // stepKey: clickOnUserDeleteUser
		$I->fillField("#user_current_password", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: typeCurrentPasswordDeleteUser
		$I->scrollToTopOfPage(); // stepKey: scrollToTopDeleteUser
		$I->click("//button/span[contains(text(), 'Delete User')]"); // stepKey: clickToDeleteUserDeleteUser
		$I->waitForPageLoad(5); // stepKey: waitForDeletePopupOpenDeleteUser
		$I->click(".action-primary.action-accept"); // stepKey: clickToConfirmDeleteUser
		$I->waitForPageLoad(10); // stepKey: waitForPageLoadDeleteUser
		$I->see("You deleted the user."); // stepKey: seeSuccessMessageDeleteUser
		$I->comment("Exiting Action Group [deleteUser] AdminDeleteNewUserActionGroup");
		$I->comment("Entering Action Group [logoutFromAdmin] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogoutFromAdmin
		$I->comment("Exiting Action Group [logoutFromAdmin] AdminLogoutActionGroup");
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
	 * @Features({"MediaGalleryUi"})
	 * @Stories({"[Story 60] User manages ACL rules for Media Gallery"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminMediaGalleryDeleteAssetsAclTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [fillUserRoleRequiredData] AdminFillUserRoleRequiredDataActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/user_role/editrole"); // stepKey: navigateToNewRoleFillUserRoleRequiredData
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad1FillUserRoleRequiredData
		$I->fillField("#role_name", "adminRole" . msq("adminRole")); // stepKey: fillRoleNameFillUserRoleRequiredData
		$I->fillField("#current_password", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: enterPasswordFillUserRoleRequiredData
		$I->comment("Exiting Action Group [fillUserRoleRequiredData] AdminFillUserRoleRequiredDataActionGroup");
		$I->comment("Entering Action Group [switchToRoleResourceTab] AdminUserClickRoleResourceTabActionGroup");
		$I->click("#role_info_tabs_account"); // stepKey: clickRoleResourcesTabSwitchToRoleResourceTab
		$I->comment("Exiting Action Group [switchToRoleResourceTab] AdminUserClickRoleResourceTabActionGroup");
		$I->comment("Entering Action Group [uncheckDeleteFolder] AdminAddRestrictedRoleActionGroup");
		$I->selectOption("#all", "0"); // stepKey: selectResourceAccessCustomUncheckDeleteFolder
		$I->scrollTo("//*[text()='Delete assets']//*[@class='jstree-checkbox']", 0, -100); // stepKey: scrollToResourceElementUncheckDeleteFolder
		$I->waitForElementVisible("//*[text()='Delete assets']//*[@class='jstree-checkbox']", 30); // stepKey: waitForElementVisibleUncheckDeleteFolder
		$I->click("//*[text()='Delete assets']//*[@class='jstree-checkbox']"); // stepKey: clickContentBlockCheckboxUncheckDeleteFolder
		$I->comment("Exiting Action Group [uncheckDeleteFolder] AdminAddRestrictedRoleActionGroup");
		$I->comment("Entering Action Group [AddMediaGalleryPagesResource] AdminAddRestrictedRoleActionGroup");
		$I->selectOption("#all", "0"); // stepKey: selectResourceAccessCustomAddMediaGalleryPagesResource
		$I->scrollTo("//*[text()='Pages']//*[@class='jstree-checkbox']", 0, -100); // stepKey: scrollToResourceElementAddMediaGalleryPagesResource
		$I->waitForElementVisible("//*[text()='Pages']//*[@class='jstree-checkbox']", 30); // stepKey: waitForElementVisibleAddMediaGalleryPagesResource
		$I->click("//*[text()='Pages']//*[@class='jstree-checkbox']"); // stepKey: clickContentBlockCheckboxAddMediaGalleryPagesResource
		$I->comment("Exiting Action Group [AddMediaGalleryPagesResource] AdminAddRestrictedRoleActionGroup");
		$I->comment("Entering Action Group [saveRole] AdminUserSaveRoleActionGroup");
		$I->click("button[title='Save Role']"); // stepKey: clickSaveRoleButtonSaveRole
		$I->waitForPageLoad(30); // stepKey: clickSaveRoleButtonSaveRoleWaitForPageLoad
		$I->see("You saved the role."); // stepKey: seeUserRoleSavedMessageSaveRole
		$I->comment("Exiting Action Group [saveRole] AdminUserSaveRoleActionGroup");
		$I->comment("Entering Action Group [createAdminUser] AdminCreateUserActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/user/"); // stepKey: amOnAdminUsersPageCreateAdminUser
		$I->waitForPageLoad(30); // stepKey: waitForAdminUserPageLoadCreateAdminUser
		$I->click("#add"); // stepKey: clickToCreateNewUserCreateAdminUser
		$I->fillField("#user_username", "admin" . msq("admin2")); // stepKey: enterUserNameCreateAdminUser
		$I->fillField("#user_firstname", "John"); // stepKey: enterFirstNameCreateAdminUser
		$I->fillField("#user_lastname", "Smith"); // stepKey: enterLastNameCreateAdminUser
		$I->fillField("#user_email", "admin" . msq("admin2") . "@magento.com"); // stepKey: enterEmailCreateAdminUser
		$I->fillField("#user_password", "admin123"); // stepKey: enterPasswordCreateAdminUser
		$I->fillField("#user_confirmation", "admin123"); // stepKey: confirmPasswordCreateAdminUser
		$I->fillField("#user_current_password", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: enterCurrentPasswordCreateAdminUser
		$I->scrollToTopOfPage(); // stepKey: scrollToTopOfPageCreateAdminUser
		$I->click("#page_tabs_roles_section"); // stepKey: clickUserRoleCreateAdminUser
		$I->waitForPageLoad(30); // stepKey: waitForAdminUserRoleTabLoadCreateAdminUser
		$I->fillField("#permissionsUserRolesGrid_filter_role_name", "adminRole" . msq("adminRole")); // stepKey: filterRoleCreateAdminUser
		$I->click(".admin__data-grid-header button[title=Search]"); // stepKey: clickSearchCreateAdminUser
		$I->waitForPageLoad(30); // stepKey: waitForLoadingMaskToDisappear1CreateAdminUser
		$I->click(".data-grid>tbody>tr"); // stepKey: selectRoleCreateAdminUser
		$I->click("#save"); // stepKey: clickSaveUserCreateAdminUser
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad2CreateAdminUser
		$I->see("You saved the user."); // stepKey: seeSuccessMessageCreateAdminUser
		$I->comment("Exiting Action Group [createAdminUser] AdminCreateUserActionGroup");
		$I->comment("Entering Action Group [logoutOfAdmin] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogoutOfAdmin
		$I->comment("Exiting Action Group [logoutOfAdmin] AdminLogoutActionGroup");
		$I->comment("Entering Action Group [loginAsNewUser] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsNewUser
		$I->fillField("#username", "admin" . msq("admin2")); // stepKey: fillUsernameLoginAsNewUser
		$I->fillField("#login", "admin123"); // stepKey: fillPasswordLoginAsNewUser
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsNewUser
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsNewUserWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsNewUser
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsNewUser
		$I->comment("Exiting Action Group [loginAsNewUser] AdminLoginActionGroup");
		$I->comment("Entering Action Group [openNewPage] AdminOpenCreateNewCMSPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/cms/page/new"); // stepKey: navigateToCreateNewPageOpenNewPage
		$I->waitForPageLoad(30); // stepKey: waitForNewPagePageLoadOpenNewPage
		$I->comment("Exiting Action Group [openNewPage] AdminOpenCreateNewCMSPageActionGroup");
		$I->comment("Entering Action Group [openMediaGalleryForPage] AdminOpenMediaGalleryFromPageNoEditorActionGroup");
		$I->conditionalClick("div[data-index=content]", "input[name=content_heading]", false); // stepKey: clickExpandContentOpenMediaGalleryForPage
		$I->waitForElementVisible(".scalable.action-add-image.plugin", 30); // stepKey: waitForInsertImageButtonOpenMediaGalleryForPage
		$I->scrollTo(".scalable.action-add-image.plugin", 0, -80); // stepKey: scrollToInsertImageButtonOpenMediaGalleryForPage
		$I->click(".scalable.action-add-image.plugin"); // stepKey: clickInsertImageOpenMediaGalleryForPage
		$I->comment("wait for initial media gallery load, where the gallery chrome loads (and triggers loading modal)");
		$I->waitForPageLoad(30); // stepKey: waitForMediaGalleryInitialLoadOpenMediaGalleryForPage
		$I->comment("wait for second media gallery load, where the gallery images load (and triggers loading modal once more)");
		$I->waitForPageLoad(30); // stepKey: waitForMediaGallerySecondaryLoadOpenMediaGalleryForPage
		$I->comment("Exiting Action Group [openMediaGalleryForPage] AdminOpenMediaGalleryFromPageNoEditorActionGroup");
		$I->comment("Entering Action Group [assertCreateButtonEnabledAllOthersDisabled] AdminAssertMediaGalleryButtonNotDisabledOnPageActionGroup");
		$verifyDisabledAttributeAssertCreateButtonEnabledAllOthersDisabled = $I->grabMultiple("//div[@class='page-actions floating-header']/button[not(@disabled='disabled') and not(@id='cancel')]"); // stepKey: verifyDisabledAttributeAssertCreateButtonEnabledAllOthersDisabled
		$I->assertEquals(["Delete Images..."], $verifyDisabledAttributeAssertCreateButtonEnabledAllOthersDisabled); // stepKey: assertSelectedCategoriesAssertCreateButtonEnabledAllOthersDisabled
		$I->comment("Exiting Action Group [assertCreateButtonEnabledAllOthersDisabled] AdminAssertMediaGalleryButtonNotDisabledOnPageActionGroup");
		$I->comment("Entering Action Group [logoutFromAdmin] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogoutFromAdmin
		$I->comment("Exiting Action Group [logoutFromAdmin] AdminLogoutActionGroup");
	}
}
