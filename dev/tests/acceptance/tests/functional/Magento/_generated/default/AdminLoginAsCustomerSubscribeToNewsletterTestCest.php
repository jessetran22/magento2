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
 * @Title("[NO TESTCASEID]: Admin user login as customer and make subscription to newsletter")
 * @Description("Verify that Admin can subscribe to newsletter using Login as Customer functionality<h3>Test files</h3>app/code/Magento/LoginAsCustomer/Test/Mftf/Test/AdminLoginAsCustomerSubscribeToNewsletterTest.xml<br>")
 * @group login_as_customer
 */
class AdminLoginAsCustomerSubscribeToNewsletterTestCest
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
	 * @Stories({"Subscribe to newsletter"})
	 * @Severity(level = SeverityLevel::MINOR)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminLoginAsCustomerSubscribeToNewsletterTest(AcceptanceTester $I)
	{
		$I->comment("Admin Login as Customer from Customer page");
		$I->comment("Entering Action Group [lLoginAsCustomerFromCustomerPage] AdminLoginAsCustomerLoginFromCustomerPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/customer/index/edit/id/" . $I->retrieveEntityField('createCustomer', 'id', 'test')); // stepKey: gotoCustomerPageLLoginAsCustomerFromCustomerPage
		$I->waitForPageLoad(30); // stepKey: waitForCustomerPageLoadLLoginAsCustomerFromCustomerPage
		$I->click("#login_as_customer"); // stepKey: clickLoginAsCustomerLinkLLoginAsCustomerFromCustomerPage
		$I->waitForPageLoad(30); // stepKey: clickLoginAsCustomerLinkLLoginAsCustomerFromCustomerPageWaitForPageLoad
		$I->see("You are about to Login as Customer", "aside.confirm .modal-title"); // stepKey: seeModalLLoginAsCustomerFromCustomerPage
		$I->see("Actions taken while in \"Login as Customer\" will affect actual customer data.", "aside.confirm .modal-content"); // stepKey: seeModalMessageLLoginAsCustomerFromCustomerPage
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: clickLoginLLoginAsCustomerFromCustomerPage
		$I->waitForPageLoad(60); // stepKey: clickLoginLLoginAsCustomerFromCustomerPageWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForLoadingMaskToDisappearLLoginAsCustomerFromCustomerPage
		$I->switchToNextTab(); // stepKey: switchToNewTabLLoginAsCustomerFromCustomerPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadLLoginAsCustomerFromCustomerPage
		$I->comment("Exiting Action Group [lLoginAsCustomerFromCustomerPage] AdminLoginAsCustomerLoginFromCustomerPageActionGroup");
		$I->comment("Subscribe for newsletter");
		$I->comment("Entering Action Group [navigateToNewsletterPage] StorefrontCustomerNavigateToNewsletterPageActionGroup");
		$I->amOnPage("/newsletter/manage/"); // stepKey: goToNewsletterPageNavigateToNewsletterPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadNavigateToNewsletterPage
		$I->comment("Exiting Action Group [navigateToNewsletterPage] StorefrontCustomerNavigateToNewsletterPageActionGroup");
		$I->comment("Entering Action Group [subscribeToNewsletter] StorefrontCustomerUpdateGeneralSubscriptionActionGroup");
		$I->click("#subscription.checkbox"); // stepKey: checkNewsLetterSubscriptionCheckboxSubscribeToNewsletter
		$I->click(".action.save.primary"); // stepKey: clickSubmitButtonSubscribeToNewsletter
		$I->comment("Exiting Action Group [subscribeToNewsletter] StorefrontCustomerUpdateGeneralSubscriptionActionGroup");
		$I->comment("Entering Action Group [assertMessage] AssertStorefrontCustomerMessagesActionGroup");
		$I->waitForElementVisible(".message-success", 30); // stepKey: waitForElementAssertMessage
		$I->see("We have saved your subscription.", ".message-success"); // stepKey: seeMessageAssertMessage
		$I->comment("Exiting Action Group [assertMessage] AssertStorefrontCustomerMessagesActionGroup");
		$I->comment("Entering Action Group [signOutAfterLoggedInAsCustomer] StorefrontSignOutAndCloseTabActionGroup");
		$I->click(".customer-name"); // stepKey: clickCustomerButtonSignOutAfterLoggedInAsCustomer
		$I->waitForElementVisible("div.customer-menu  li.authorization-link", 30); // stepKey: waitForSignOutSignOutAfterLoggedInAsCustomer
		$I->click("div.customer-menu  li.authorization-link"); // stepKey: clickToSignOutSignOutAfterLoggedInAsCustomer
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadSignOutAfterLoggedInAsCustomer
		$I->see("You are signed out"); // stepKey: signOutSignOutAfterLoggedInAsCustomer
		$I->closeTab(); // stepKey: closeTabSignOutAfterLoggedInAsCustomer
		$I->comment("Exiting Action Group [signOutAfterLoggedInAsCustomer] StorefrontSignOutAndCloseTabActionGroup");
		$I->comment("Verify subscription successful");
		$I->comment("Entering Action Group [openCustomerEditPage] AdminOpenCustomerEditPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/customer/index/edit/id/" . $I->retrieveEntityField('createCustomer', 'id', 'test')); // stepKey: openCustomerEditPageOpenCustomerEditPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadOpenCustomerEditPage
		$I->comment("Exiting Action Group [openCustomerEditPage] AdminOpenCustomerEditPageActionGroup");
		$I->comment("Entering Action Group [assertSubscribedToNewsletter] AdminAssertCustomerIsSubscribedToNewsletters");
		$I->click("//a[@class='admin__page-nav-link' and @id='tab_newsletter_content']"); // stepKey: clickToNewsletterTabHeaderAssertSubscribedToNewsletter
		$I->waitForPageLoad(30); // stepKey: clickToNewsletterTabHeaderAssertSubscribedToNewsletterWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForShowNewsletterTabAssertSubscribedToNewsletter
		$I->seeCheckboxIsChecked("//div[@class='admin__field-control control']//input[@name='subscription_status[1]']"); // stepKey: assertSubscribedToNewsletterAssertSubscribedToNewsletter
		$I->comment("Exiting Action Group [assertSubscribedToNewsletter] AdminAssertCustomerIsSubscribedToNewsletters");
	}
}
