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
 * @Title(": Create new user with invalid expiration date")
 * @Description("Create new user with invalid expiration date.<h3>Test files</h3>app/code/Magento/Security/Test/Mftf/Test/AdminCreateNewUserWithInvalidExpirationTest.xml<br>")
 * @TestCaseId("")
 * @group security
 */
class AdminCreateNewUserWithInvalidExpirationTestCest
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
    }
	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _before(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdminWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin
		$I->comment("Exiting Action Group [loginAsAdmin] AdminLoginActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [logout] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogout
		$I->comment("Exiting Action Group [logout] AdminLogoutActionGroup");
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
	 * @Features({"Security"})
	 * @Stories({"Create new user with invalid expiration date."})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminCreateNewUserWithInvalidExpirationTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [openNewUserPage] AdminOpenNewUserPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/user/new"); // stepKey: amOnNewAdminUserPageOpenNewUserPage
		$I->waitForPageLoad(30); // stepKey: waitForNewAdminUserPageLoadOpenNewUserPage
		$I->comment("Exiting Action Group [openNewUserPage] AdminOpenNewUserPageActionGroup");
		$date = new \DateTime();
		$date->setTimestamp(strtotime("-5 day"));
		$date->setTimezone(new \DateTimeZone("America/Los_Angeles"));
		$expiresDateTime = $date->format("M j, Y g:i:s A");

		$I->comment("Entering Action Group [fillInNewUserWithValidExpiration] AdminFillInUserWithExpirationActionGroup");
		$I->fillField("#page_tabs_main_section_content input[name='username']", "admin" . msq("NewAdminUser")); // stepKey: fillUserFillInNewUserWithValidExpiration
		$I->fillField("#page_tabs_main_section_content input[name='firstname']", "John"); // stepKey: fillFirstNameFillInNewUserWithValidExpiration
		$I->fillField("#page_tabs_main_section_content input[name='lastname']", "Doe"); // stepKey: fillLastNameFillInNewUserWithValidExpiration
		$I->fillField("#page_tabs_main_section_content input[name='email']", msq("NewAdminUser") . "admin@example.com"); // stepKey: fillEmailFillInNewUserWithValidExpiration
		$I->fillField("#page_tabs_main_section_content input[name='password']", "123123q"); // stepKey: fillPasswordFillInNewUserWithValidExpiration
		$I->fillField("#page_tabs_main_section_content input[name='password_confirmation']", "123123q"); // stepKey: fillPasswordConfirmationFillInNewUserWithValidExpiration
		$I->fillField("#page_tabs_main_section_content input[name='expires_at']", $expiresDateTime); // stepKey: fillExpireDateFillInNewUserWithValidExpiration
		$I->fillField("#page_tabs_main_section_content input[name='current_password']", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillCurrentUserPasswordFillInNewUserWithValidExpiration
		$I->scrollToTopOfPage(); // stepKey: scrollToTopOfPageFillInNewUserWithValidExpiration
		$I->click("#page_tabs_roles_section"); // stepKey: openUserRoleTabFillInNewUserWithValidExpiration
		$I->waitForPageLoad(30); // stepKey: waitForUserRoleTabOpenedFillInNewUserWithValidExpiration
		$I->click("#page_tabs_roles_section_content #permissionsUserRolesGrid [data-action='grid-filter-reset']"); // stepKey: resetGridFilterFillInNewUserWithValidExpiration
		$I->waitForPageLoad(30); // stepKey: waitForFiltersResetFillInNewUserWithValidExpiration
		$I->fillField("#page_tabs_roles_section_content #permissionsUserRolesGrid input[name='role_name']", "Administrators"); // stepKey: fillRoleFilterFieldFillInNewUserWithValidExpiration
		$I->click("#page_tabs_roles_section_content #permissionsUserRolesGrid [data-action='grid-filter-apply']"); // stepKey: clickSearchButtonFillInNewUserWithValidExpiration
		$I->waitForPageLoad(30); // stepKey: waitForFiltersAppliedFillInNewUserWithValidExpiration
		$I->checkOption("//table[@id='permissionsUserRolesGrid_table']//tr[./td[contains(@class, 'col-role_name') and contains(., 'Administrators')]]//input[@name='roles[]']"); // stepKey: assignRoleFillInNewUserWithValidExpiration
		$I->comment("Exiting Action Group [fillInNewUserWithValidExpiration] AdminFillInUserWithExpirationActionGroup");
		$I->comment("Entering Action Group [saveNewUserWithInvalidExpirationError] AdminSaveUserInvalidExpirationActionGroup");
		$I->click(".page-main-actions #save"); // stepKey: clickSaveUserSaveNewUserWithInvalidExpirationError
		$I->waitForPageLoad(30); // stepKey: waitForSaveTheUserSaveNewUserWithInvalidExpirationError
		$I->scrollToTopOfPage(); // stepKey: scrollToTopOfPageSaveNewUserWithInvalidExpirationError
		$I->click("#page_tabs_main_section"); // stepKey: openUserTabSaveNewUserWithInvalidExpirationError
		$I->waitForPageLoad(30); // stepKey: waitForUserRoleTabOpenedSaveNewUserWithInvalidExpirationError
		$I->see("\"Expiration date\" must be later than the current date.", "#messages div.message-error"); // stepKey: seeErrorMessageSaveNewUserWithInvalidExpirationError
		$I->comment("Exiting Action Group [saveNewUserWithInvalidExpirationError] AdminSaveUserInvalidExpirationActionGroup");
	}
}
