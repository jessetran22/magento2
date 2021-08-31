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
 * @Title("[NO TESTCASEID]: Admin users can have only one 'Login as Customer' session at a time")
 * @Description("Verify Admin users can have only one 'Login as Customer' session at a time<h3>Test files</h3>app/code/Magento/LoginAsCustomer/Test/Mftf/Test/AdminLoginAsCustomerUserSingleSessionTest.xml<br>")
 * @group login_as_customer
 */
class AdminLoginAsCustomerUserSingleSessionTestCest
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
		$enableLoginAsCustomer = $I->magentoCLI("config:set login_as_customer/general/enabled 1", 60); // stepKey: enableLoginAsCustomer
		$I->comment($enableLoginAsCustomer);
		$enableLoginAsCustomerAutoDetection = $I->magentoCLI("config:set login_as_customer/general/store_view_manual_choice_enabled 0", 60); // stepKey: enableLoginAsCustomerAutoDetection
		$I->comment($enableLoginAsCustomerAutoDetection);
		$I->comment("Adding the comment to replace 'cache:flush' command for preserving Backward Compatibility");
		$I->createEntity("createFirstCustomer", "hook", "Simple_US_Customer_Assistance_Allowed", [], []); // stepKey: createFirstCustomer
		$I->createEntity("createSecondCustomer", "hook", "Simple_US_CA_Customer_Assistance_Allowed", [], []); // stepKey: createSecondCustomer
		$I->comment("Entering Action Group [loginAsDefaultUser] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsDefaultUser
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsDefaultUser
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsDefaultUser
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsDefaultUser
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsDefaultUserWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsDefaultUser
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsDefaultUser
		$I->comment("Exiting Action Group [loginAsDefaultUser] AdminLoginActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->deleteEntity("createFirstCustomer", "hook"); // stepKey: deleteFirstCustomer
		$I->deleteEntity("createSecondCustomer", "hook"); // stepKey: deleteSecondCustomer
		$I->comment("Entering Action Group [logoutAfter] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogoutAfter
		$I->comment("Exiting Action Group [logoutAfter] AdminLogoutActionGroup");
		$disableLoginAsCustomer = $I->magentoCLI("config:set login_as_customer/general/enabled 0", 60); // stepKey: disableLoginAsCustomer
		$I->comment($disableLoginAsCustomer);
		$I->comment("Adding the comment to replace 'cache:flush' command for preserving Backward Compatibility");
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
	 * @Features({"LoginAsCustomer"})
	 * @Stories({"Destroy impersonated customer sessions on admin logout"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminLoginAsCustomerUserSingleSessionTest(AcceptanceTester $I)
	{
		$I->comment("Login into First Customer account");
		$I->comment("Entering Action Group [loginAsFirstCustomer] AdminLoginAsCustomerLoginFromCustomerPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/customer/index/edit/id/" . $I->retrieveEntityField('createFirstCustomer', 'id', 'test')); // stepKey: gotoCustomerPageLoginAsFirstCustomer
		$I->waitForPageLoad(30); // stepKey: waitForCustomerPageLoadLoginAsFirstCustomer
		$I->click("#login_as_customer"); // stepKey: clickLoginAsCustomerLinkLoginAsFirstCustomer
		$I->waitForPageLoad(30); // stepKey: clickLoginAsCustomerLinkLoginAsFirstCustomerWaitForPageLoad
		$I->see("You are about to Login as Customer", "aside.confirm .modal-title"); // stepKey: seeModalLoginAsFirstCustomer
		$I->see("Actions taken while in \"Login as Customer\" will affect actual customer data.", "aside.confirm .modal-content"); // stepKey: seeModalMessageLoginAsFirstCustomer
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: clickLoginLoginAsFirstCustomer
		$I->waitForPageLoad(60); // stepKey: clickLoginLoginAsFirstCustomerWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForLoadingMaskToDisappearLoginAsFirstCustomer
		$I->switchToNextTab(); // stepKey: switchToNewTabLoginAsFirstCustomer
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadLoginAsFirstCustomer
		$I->comment("Exiting Action Group [loginAsFirstCustomer] AdminLoginAsCustomerLoginFromCustomerPageActionGroup");
		$I->comment("Assert correctly logged in as First Customer");
		$I->comment("Entering Action Group [assertLoggedInFromFirstCustomerPage] StorefrontAssertLoginAsCustomerLoggedInActionGroup");
		$I->seeInCurrentUrl("/customer/account/"); // stepKey: assertOnCustomerAccountPageAssertLoggedInFromFirstCustomerPage
		$I->see("Welcome, " . $I->retrieveEntityField('createFirstCustomer', 'firstname', 'test') . " " . $I->retrieveEntityField('createFirstCustomer', 'lastname', 'test') . "!", "header>.panel .greet.welcome"); // stepKey: assertCorrectWelcomeMessageAssertLoggedInFromFirstCustomerPage
		$I->see($I->retrieveEntityField('createFirstCustomer', 'email', 'test'), ".box.box-information .box-content"); // stepKey: assertCustomerEmailInContactInformationAssertLoggedInFromFirstCustomerPage
		$I->comment("Exiting Action Group [assertLoggedInFromFirstCustomerPage] StorefrontAssertLoginAsCustomerLoggedInActionGroup");
		$I->comment("Login into Second Customer account");
		$I->comment("Entering Action Group [loginAsSecondCustomer] AdminLoginAsCustomerLoginFromCustomerPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/customer/index/edit/id/" . $I->retrieveEntityField('createSecondCustomer', 'id', 'test')); // stepKey: gotoCustomerPageLoginAsSecondCustomer
		$I->waitForPageLoad(30); // stepKey: waitForCustomerPageLoadLoginAsSecondCustomer
		$I->click("#login_as_customer"); // stepKey: clickLoginAsCustomerLinkLoginAsSecondCustomer
		$I->waitForPageLoad(30); // stepKey: clickLoginAsCustomerLinkLoginAsSecondCustomerWaitForPageLoad
		$I->see("You are about to Login as Customer", "aside.confirm .modal-title"); // stepKey: seeModalLoginAsSecondCustomer
		$I->see("Actions taken while in \"Login as Customer\" will affect actual customer data.", "aside.confirm .modal-content"); // stepKey: seeModalMessageLoginAsSecondCustomer
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: clickLoginLoginAsSecondCustomer
		$I->waitForPageLoad(60); // stepKey: clickLoginLoginAsSecondCustomerWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForLoadingMaskToDisappearLoginAsSecondCustomer
		$I->switchToNextTab(); // stepKey: switchToNewTabLoginAsSecondCustomer
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadLoginAsSecondCustomer
		$I->comment("Exiting Action Group [loginAsSecondCustomer] AdminLoginAsCustomerLoginFromCustomerPageActionGroup");
		$I->comment("Assert correctly logged in as Second Customer");
		$I->comment("Entering Action Group [assertLoggedInFromSecondCustomerPage] StorefrontAssertLoginAsCustomerLoggedInActionGroup");
		$I->seeInCurrentUrl("/customer/account/"); // stepKey: assertOnCustomerAccountPageAssertLoggedInFromSecondCustomerPage
		$I->see("Welcome, " . $I->retrieveEntityField('createSecondCustomer', 'firstname', 'test') . " " . $I->retrieveEntityField('createSecondCustomer', 'lastname', 'test') . "!", "header>.panel .greet.welcome"); // stepKey: assertCorrectWelcomeMessageAssertLoggedInFromSecondCustomerPage
		$I->see($I->retrieveEntityField('createSecondCustomer', 'email', 'test'), ".box.box-information .box-content"); // stepKey: assertCustomerEmailInContactInformationAssertLoggedInFromSecondCustomerPage
		$I->comment("Exiting Action Group [assertLoggedInFromSecondCustomerPage] StorefrontAssertLoginAsCustomerLoggedInActionGroup");
		$I->comment("Entering Action Group [signOutSecondCustomer] StorefrontSignOutAndCloseTabActionGroup");
		$I->click(".customer-name"); // stepKey: clickCustomerButtonSignOutSecondCustomer
		$I->waitForElementVisible("div.customer-menu  li.authorization-link", 30); // stepKey: waitForSignOutSignOutSecondCustomer
		$I->click("div.customer-menu  li.authorization-link"); // stepKey: clickToSignOutSignOutSecondCustomer
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadSignOutSecondCustomer
		$I->see("You are signed out"); // stepKey: signOutSignOutSecondCustomer
		$I->closeTab(); // stepKey: closeTabSignOutSecondCustomer
		$I->comment("Exiting Action Group [signOutSecondCustomer] StorefrontSignOutAndCloseTabActionGroup");
	}
}
