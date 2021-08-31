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
 * @Title("[NO TESTCASEID]: Login as Customer sessions are ended/invalidated when the related admin session is logged out.")
 * @Description("Verify Login as Customer session is ended/invalidated when the related admin session is logged out.<h3>Test files</h3>app/code/Magento/LoginAsCustomer/Test/Mftf/Test/AdminLoginAsCustomerUserLogoutTest.xml<br>")
 * @group login_as_customer
 */
class AdminLoginAsCustomerUserLogoutTestCest
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
		$I->createEntity("createCustomer", "hook", "Simple_US_Customer_Assistance_Allowed", [], []); // stepKey: createCustomer
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
		$I->deleteEntity("createCustomer", "hook"); // stepKey: deleteCustomer
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
	public function AdminLoginAsCustomerUserLogoutTest(AcceptanceTester $I)
	{
		$I->comment("Login into Customer account");
		$I->comment("Entering Action Group [loginAsCustomer] AdminLoginAsCustomerLoginFromCustomerPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/customer/index/edit/id/" . $I->retrieveEntityField('createCustomer', 'id', 'test')); // stepKey: gotoCustomerPageLoginAsCustomer
		$I->waitForPageLoad(30); // stepKey: waitForCustomerPageLoadLoginAsCustomer
		$I->click("#login_as_customer"); // stepKey: clickLoginAsCustomerLinkLoginAsCustomer
		$I->waitForPageLoad(30); // stepKey: clickLoginAsCustomerLinkLoginAsCustomerWaitForPageLoad
		$I->see("You are about to Login as Customer", "aside.confirm .modal-title"); // stepKey: seeModalLoginAsCustomer
		$I->see("Actions taken while in \"Login as Customer\" will affect actual customer data.", "aside.confirm .modal-content"); // stepKey: seeModalMessageLoginAsCustomer
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: clickLoginLoginAsCustomer
		$I->waitForPageLoad(60); // stepKey: clickLoginLoginAsCustomerWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForLoadingMaskToDisappearLoginAsCustomer
		$I->switchToNextTab(); // stepKey: switchToNewTabLoginAsCustomer
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadLoginAsCustomer
		$I->comment("Exiting Action Group [loginAsCustomer] AdminLoginAsCustomerLoginFromCustomerPageActionGroup");
		$I->comment("Assert correctly logged in as Customer");
		$I->comment("Entering Action Group [assertLoggedInFromCustomerPage] StorefrontAssertLoginAsCustomerLoggedInActionGroup");
		$I->seeInCurrentUrl("/customer/account/"); // stepKey: assertOnCustomerAccountPageAssertLoggedInFromCustomerPage
		$I->see("Welcome, " . $I->retrieveEntityField('createCustomer', 'firstname', 'test') . " " . $I->retrieveEntityField('createCustomer', 'lastname', 'test') . "!", "header>.panel .greet.welcome"); // stepKey: assertCorrectWelcomeMessageAssertLoggedInFromCustomerPage
		$I->see($I->retrieveEntityField('createCustomer', 'email', 'test'), ".box.box-information .box-content"); // stepKey: assertCustomerEmailInContactInformationAssertLoggedInFromCustomerPage
		$I->comment("Exiting Action Group [assertLoggedInFromCustomerPage] StorefrontAssertLoginAsCustomerLoggedInActionGroup");
		$I->comment("End Admin session");
		$I->comment("Entering Action Group [adminLogout] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageAdminLogout
		$I->comment("Exiting Action Group [adminLogout] AdminLogoutActionGroup");
		$I->comment("Assert Customer session invalidated");
		$I->comment("Entering Action Group [openCustomerAccountPage] StorefrontOpenMyAccountPageActionGroup");
		$I->amOnPage("/customer/account/"); // stepKey: goToMyAccountPageOpenCustomerAccountPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadOpenCustomerAccountPage
		$I->comment("Exiting Action Group [openCustomerAccountPage] StorefrontOpenMyAccountPageActionGroup");
		$I->comment("Entering Action Group [AssertOnCustomerLoginPage] StorefrontAssertOnCustomerLoginPageActionGroup");
		$I->seeInCurrentUrl("/customer/account/login/"); // stepKey: seeOnSignInPageAssertOnCustomerLoginPage
		$I->comment("Exiting Action Group [AssertOnCustomerLoginPage] StorefrontAssertOnCustomerLoginPageActionGroup");
	}
}
