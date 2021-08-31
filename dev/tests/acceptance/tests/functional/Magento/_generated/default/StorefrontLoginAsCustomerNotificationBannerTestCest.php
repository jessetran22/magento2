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
 * @Title("[NO TESTCASEID]: Notification Banner is present on Storefront page")
 * @Description("Verify that Notification Banner is present on page if 'Login as customer' functionality used<h3>Test files</h3>app/code/Magento/LoginAsCustomer/Test/Mftf/Test/StorefrontLoginAsCustomerNotificationBannerTest.xml<br>")
 * @group login_as_customer
 */
class StorefrontLoginAsCustomerNotificationBannerTestCest
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
		$I->createEntity("createCustomer", "hook", "Simple_US_Customer_Assistance_Allowed", [], []); // stepKey: createCustomer
		$enableLoginAsCustomer = $I->magentoCLI("config:set login_as_customer/general/enabled 1", 60); // stepKey: enableLoginAsCustomer
		$I->comment($enableLoginAsCustomer);
		$enableLoginAsCustomerAutoDetection = $I->magentoCLI("config:set login_as_customer/general/store_view_manual_choice_enabled 0", 60); // stepKey: enableLoginAsCustomerAutoDetection
		$I->comment($enableLoginAsCustomerAutoDetection);
		$I->comment("Adding the comment to replace 'cache:flush' command for preserving Backward Compatibility");
		$I->comment("Entering Action Group [adminLogin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminAdminLogin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameAdminLogin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordAdminLogin
		$I->click(".actions .action-primary"); // stepKey: clickLoginAdminLogin
		$I->waitForPageLoad(30); // stepKey: clickLoginAdminLoginWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleAdminLogin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationAdminLogin
		$I->comment("Exiting Action Group [adminLogin] AdminLoginActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->deleteEntity("createCustomer", "hook"); // stepKey: deleteCustomer
		$I->comment("Entering Action Group [logout] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogout
		$I->comment("Exiting Action Group [logout] AdminLogoutActionGroup");
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
	 * @Stories({"Availability of UI elements if module enable/disable"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StorefrontLoginAsCustomerNotificationBannerTest(AcceptanceTester $I)
	{
		$I->comment("Login as Customer from Customer page");
		$I->comment("Entering Action Group [loginAsCustomerFromCustomerPage] AdminLoginAsCustomerLoginFromCustomerPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/customer/index/edit/id/" . $I->retrieveEntityField('createCustomer', 'id', 'test')); // stepKey: gotoCustomerPageLoginAsCustomerFromCustomerPage
		$I->waitForPageLoad(30); // stepKey: waitForCustomerPageLoadLoginAsCustomerFromCustomerPage
		$I->click("#login_as_customer"); // stepKey: clickLoginAsCustomerLinkLoginAsCustomerFromCustomerPage
		$I->waitForPageLoad(30); // stepKey: clickLoginAsCustomerLinkLoginAsCustomerFromCustomerPageWaitForPageLoad
		$I->see("You are about to Login as Customer", "aside.confirm .modal-title"); // stepKey: seeModalLoginAsCustomerFromCustomerPage
		$I->see("Actions taken while in \"Login as Customer\" will affect actual customer data.", "aside.confirm .modal-content"); // stepKey: seeModalMessageLoginAsCustomerFromCustomerPage
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: clickLoginLoginAsCustomerFromCustomerPage
		$I->waitForPageLoad(60); // stepKey: clickLoginLoginAsCustomerFromCustomerPageWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForLoadingMaskToDisappearLoginAsCustomerFromCustomerPage
		$I->switchToNextTab(); // stepKey: switchToNewTabLoginAsCustomerFromCustomerPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadLoginAsCustomerFromCustomerPage
		$I->comment("Exiting Action Group [loginAsCustomerFromCustomerPage] AdminLoginAsCustomerLoginFromCustomerPageActionGroup");
		$I->comment("Assert Notification Banner is present on page");
		$I->comment("Entering Action Group [assertNotificationBanner] StorefrontAssertLoginAsCustomerNotificationBannerActionGroup");
		$I->waitForElementVisible("//div[contains(@class, 'lac-notification')]//div[contains(@class, 'lac-notification-text')]/span", 30); // stepKey: waitForNotificationBannerAssertNotificationBanner
		$I->waitForPageLoad(30); // stepKey: waitForNotificationBannerAssertNotificationBannerWaitForPageLoad
		$I->see("You are connected as " . $I->retrieveEntityField('createCustomer', 'firstname', 'test') . " " . $I->retrieveEntityField('createCustomer', 'lastname', 'test') . " on Main Website", "//div[contains(@class, 'lac-notification')]//div[contains(@class, 'lac-notification-text')]/span"); // stepKey: assertCorrectNotificationBannerMessageAssertNotificationBanner
		$I->waitForPageLoad(30); // stepKey: assertCorrectNotificationBannerMessageAssertNotificationBannerWaitForPageLoad
		$I->seeElement("//div[contains(@class, 'lac-notification')]//div[contains(@class, 'lac-notification-links')]/a[contains(@class, 'lac-notification-close-link')]"); // stepKey: assertCloseNotificationBannerPresentAssertNotificationBanner
		$I->waitForPageLoad(30); // stepKey: assertCloseNotificationBannerPresentAssertNotificationBannerWaitForPageLoad
		$I->comment("Exiting Action Group [assertNotificationBanner] StorefrontAssertLoginAsCustomerNotificationBannerActionGroup");
		$I->comment("Log out Customer by Notification Banner and close tab");
		$I->comment("Entering Action Group [signOutAndCloseTab] StorefrontSignOutNotificationBannerAndCloseTabActionGroup");
		$I->waitForElementVisible("//div[contains(@class, 'lac-notification')]//div[contains(@class, 'lac-notification-text')]/span", 30); // stepKey: waitForNotificationBannerSignOutAndCloseTab
		$I->waitForPageLoad(30); // stepKey: waitForNotificationBannerSignOutAndCloseTabWaitForPageLoad
		$I->click("//div[contains(@class, 'lac-notification')]//div[contains(@class, 'lac-notification-links')]/a[contains(@class, 'lac-notification-close-link')]"); // stepKey: clickToSignOutSignOutAndCloseTab
		$I->waitForPageLoad(30); // stepKey: clickToSignOutSignOutAndCloseTabWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadSignOutAndCloseTab
		$I->see("You are signed out"); // stepKey: signOutSignOutAndCloseTab
		$I->closeTab(); // stepKey: closeTabSignOutAndCloseTab
		$I->comment("Exiting Action Group [signOutAndCloseTab] StorefrontSignOutNotificationBannerAndCloseTabActionGroup");
	}
}
