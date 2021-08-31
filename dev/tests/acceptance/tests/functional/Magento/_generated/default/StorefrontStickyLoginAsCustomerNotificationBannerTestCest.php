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
 * @Title(": Sticky Notification Banner is present on Storefront page")
 * @Description("Verify that Sticky Notification Banner is present on page if 'Login as customer' functionality used<h3>Test files</h3>app/code/Magento/LoginAsCustomer/Test/Mftf/Test/StorefrontStickyLoginAsCustomerNotificationBannerTest.xml<br>")
 * @TestCaseId("")
 * @group login_as_customer
 */
class StorefrontStickyLoginAsCustomerNotificationBannerTestCest
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
		$I->comment("Entering Action Group [cleanConfigCache] CliCacheCleanActionGroup");
		$cleanSpecifiedCacheCleanConfigCache = $I->magentoCLI("cache:clean", 60, "config"); // stepKey: cleanSpecifiedCacheCleanConfigCache
		$I->comment($cleanSpecifiedCacheCleanConfigCache);
		$I->comment("Exiting Action Group [cleanConfigCache] CliCacheCleanActionGroup");
		$I->createEntity("createCustomer", "hook", "Simple_US_Customer_Assistance_Allowed", [], []); // stepKey: createCustomer
		$I->comment("Entering Action Group [login] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLogin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLogin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLogin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLogin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLogin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLogin
		$I->comment("Exiting Action Group [login] AdminLoginActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->deleteEntity("createCustomer", "hook"); // stepKey: deleteCustomer
		$disableLoginAsCustomer = $I->magentoCLI("config:set login_as_customer/general/enabled 0", 60); // stepKey: disableLoginAsCustomer
		$I->comment($disableLoginAsCustomer);
		$I->comment("Entering Action Group [cleanConfigCache] CliCacheCleanActionGroup");
		$cleanSpecifiedCacheCleanConfigCache = $I->magentoCLI("cache:clean", 60, "config"); // stepKey: cleanSpecifiedCacheCleanConfigCache
		$I->comment($cleanSpecifiedCacheCleanConfigCache);
		$I->comment("Exiting Action Group [cleanConfigCache] CliCacheCleanActionGroup");
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
	 * @Stories({"Availability of sticky UI elements if module enable/disable"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StorefrontStickyLoginAsCustomerNotificationBannerTest(AcceptanceTester $I)
	{
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
		$I->comment("Entering Action Group [assertStickyNotificationBanner] AssertStorefrontStickyLoginAsCustomerNotificationBannerActionGroup");
		$I->waitForElementVisible("//div[contains(@class, 'lac-notification')]//div[contains(@class, 'lac-notification-text')]/span", 30); // stepKey: waitForNotificationBannerAssertStickyNotificationBanner
		$I->waitForPageLoad(30); // stepKey: waitForNotificationBannerAssertStickyNotificationBannerWaitForPageLoad
		$I->see("You are connected as " . $I->retrieveEntityField('createCustomer', 'firstname', 'test') . " " . $I->retrieveEntityField('createCustomer', 'lastname', 'test') . " on Main Website", "//div[contains(@class, 'lac-notification')]//div[contains(@class, 'lac-notification-text')]/span"); // stepKey: assertCorrectNotificationBannerMessageAssertStickyNotificationBanner
		$I->waitForPageLoad(30); // stepKey: assertCorrectNotificationBannerMessageAssertStickyNotificationBannerWaitForPageLoad
		$I->seeElement("//div[contains(@class, 'lac-notification')]//div[contains(@class, 'lac-notification-links')]/a[contains(@class, 'lac-notification-close-link')]"); // stepKey: assertCloseNotificationBannerPresentAssertStickyNotificationBanner
		$I->waitForPageLoad(30); // stepKey: assertCloseNotificationBannerPresentAssertStickyNotificationBannerWaitForPageLoad
		$scrollToBottomOfPageAssertStickyNotificationBanner = $I->executeJS("window.scrollTo(0,document.body.scrollHeight);"); // stepKey: scrollToBottomOfPageAssertStickyNotificationBanner
		$I->see("You are connected as " . $I->retrieveEntityField('createCustomer', 'firstname', 'test') . " " . $I->retrieveEntityField('createCustomer', 'lastname', 'test') . " on Main Website", "//div[contains(@class, 'lac-notification')]//div[contains(@class, 'lac-notification-text')]/span"); // stepKey: assertCorrectNotificationBannerMessageAfterScrollAssertStickyNotificationBanner
		$I->waitForPageLoad(30); // stepKey: assertCorrectNotificationBannerMessageAfterScrollAssertStickyNotificationBannerWaitForPageLoad
		$I->seeElement("//div[contains(@class, 'lac-notification')]//div[contains(@class, 'lac-notification-links')]/a[contains(@class, 'lac-notification-close-link')]"); // stepKey: assertCloseNotificationBannerPresentAfterScrollAssertStickyNotificationBanner
		$I->waitForPageLoad(30); // stepKey: assertCloseNotificationBannerPresentAfterScrollAssertStickyNotificationBannerWaitForPageLoad
		$I->comment("Exiting Action Group [assertStickyNotificationBanner] AssertStorefrontStickyLoginAsCustomerNotificationBannerActionGroup");
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
