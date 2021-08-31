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
 * @Title("[NO TESTCASEID]: Admin deletes newsletter subscribers")
 * @Description("Admin should be able delete newsletter subscribers<h3>Test files</h3>app/code/Magento/Newsletter/Test/Mftf/Test/AdminMarketingDeleteNewsletterSubscriberTest.xml<br>")
 * @group newsletter
 */
class AdminMarketingDeleteNewsletterSubscriberTestCest
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
		$I->createEntity("createCustomer", "hook", "Simple_US_Customer", [], []); // stepKey: createCustomer
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->deleteEntity("createCustomer", "hook"); // stepKey: deleteCreatedCustomer
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
	 * @Features({"Newsletter"})
	 * @Stories({"Subscribers Deleting"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminMarketingDeleteNewsletterSubscriberTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [loginAsCustomer] LoginToStorefrontActionGroup");
		$I->amOnPage("/customer/account/login/"); // stepKey: amOnSignInPageLoginAsCustomer
		$I->waitForPageLoad(30); // stepKey: waitPageFullyLoadedLoginAsCustomer
		$I->waitForElementVisible("#email", 30); // stepKey: waitFormAppearsLoginAsCustomer
		$I->fillField("#email", $I->retrieveEntityField('createCustomer', 'email', 'test')); // stepKey: fillEmailLoginAsCustomer
		$I->fillField("#pass", $I->retrieveEntityField('createCustomer', 'password', 'test')); // stepKey: fillPasswordLoginAsCustomer
		$I->click("#send2"); // stepKey: clickSignInAccountButtonLoginAsCustomer
		$I->waitForPageLoad(30); // stepKey: clickSignInAccountButtonLoginAsCustomerWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCustomerLoggedInLoginAsCustomer
		$I->comment("Exiting Action Group [loginAsCustomer] LoginToStorefrontActionGroup");
		$I->comment("Entering Action Group [navigateToNewsletterPage] StorefrontCustomerNavigateToNewsletterPageActionGroup");
		$I->amOnPage("/newsletter/manage/"); // stepKey: goToNewsletterPageNavigateToNewsletterPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadNavigateToNewsletterPage
		$I->comment("Exiting Action Group [navigateToNewsletterPage] StorefrontCustomerNavigateToNewsletterPageActionGroup");
		$I->comment("Entering Action Group [subscribeToNewsletter] StorefrontCustomerUpdateGeneralSubscriptionActionGroup");
		$I->click("#subscription.checkbox"); // stepKey: checkNewsLetterSubscriptionCheckboxSubscribeToNewsletter
		$I->click(".action.save.primary"); // stepKey: clickSubmitButtonSubscribeToNewsletter
		$I->comment("Exiting Action Group [subscribeToNewsletter] StorefrontCustomerUpdateGeneralSubscriptionActionGroup");
		$I->comment("Entering Action Group [LoginAsAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdminWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin
		$I->comment("Exiting Action Group [LoginAsAdmin] AdminLoginActionGroup");
		$I->comment("Entering Action Group [navigateToNewsletterSubscribersPage] AdminNavigateMenuActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitPageLoadNavigateToNewsletterSubscribersPage
		$I->click("li[data-ui-id='menu-magento-backend-marketing']"); // stepKey: clickOnMenuItemNavigateToNewsletterSubscribersPage
		$I->waitForPageLoad(30); // stepKey: clickOnMenuItemNavigateToNewsletterSubscribersPageWaitForPageLoad
		$I->click("li[data-ui-id='menu-magento-newsletter-newsletter-subscriber']"); // stepKey: clickOnSubmenuItemNavigateToNewsletterSubscribersPage
		$I->waitForPageLoad(30); // stepKey: clickOnSubmenuItemNavigateToNewsletterSubscribersPageWaitForPageLoad
		$I->comment("Exiting Action Group [navigateToNewsletterSubscribersPage] AdminNavigateMenuActionGroup");
		$I->comment("Entering Action Group [findSubscriber] AdminMarketingFindNewsletterSubscribersInGridActionGroup");
		$I->click(".action-default.scalable.action-reset.action-tertiary"); // stepKey: resetFilterFindSubscriber
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadingFindSubscriber
		$I->fillField(".col-email #subscriberGrid_filter_email", msq("Simple_US_Customer") . "John.Doe@example.com"); // stepKey: fillEmailFieldFindSubscriber
		$I->click("//*[@class='admin__filter-actions']//*[text()='Search']"); // stepKey: clickSearchButtonFindSubscriber
		$I->waitForPageLoad(30); // stepKey: waitForResultsLoadingFindSubscriber
		$I->comment("Exiting Action Group [findSubscriber] AdminMarketingFindNewsletterSubscribersInGridActionGroup");
		$I->comment("Entering Action Group [deleteSubscriber] AdminMarketingDeleteNewsletterSubscriberFromGridActionGroup");
		$I->click("table.data-grid tbody > tr:nth-of-type(1) td.data-grid-checkbox-cell input"); // stepKey: clickOnFirstCheckboxDeleteSubscriber
		$I->selectOption(".admin__grid-massaction-form #subscriberGrid_massaction-select", "Delete"); // stepKey: selectDeleteDeleteSubscriber
		$I->click("//*[@class='admin__grid-massaction-form']//*[text()='Submit']"); // stepKey: clickSubmitBtnDeleteSubscriber
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadDeleteSubscriber
		$I->click("//footer[@class='modal-footer']/button[contains(@class, 'action-accept')]"); // stepKey: clickOkButtonDeleteSubscriber
		$I->waitForPageLoad(30); // stepKey: clickOkButtonDeleteSubscriberWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForResultsLoadingDeleteSubscriber
		$I->comment("Exiting Action Group [deleteSubscriber] AdminMarketingDeleteNewsletterSubscriberFromGridActionGroup");
		$I->comment("Entering Action Group [assertSuccessMessage] AssertMessageInAdminPanelActionGroup");
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitForMessageVisibleAssertSuccessMessage
		$I->see("Total of 1 record(s) were deleted.", "#messages div.message-success"); // stepKey: verifyMessageAssertSuccessMessage
		$I->comment("Exiting Action Group [assertSuccessMessage] AssertMessageInAdminPanelActionGroup");
		$I->comment("Entering Action Group [findDeletedSubscriber] AdminMarketingFindNewsletterSubscribersInGridActionGroup");
		$I->click(".action-default.scalable.action-reset.action-tertiary"); // stepKey: resetFilterFindDeletedSubscriber
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadingFindDeletedSubscriber
		$I->fillField(".col-email #subscriberGrid_filter_email", msq("Simple_US_Customer") . "John.Doe@example.com"); // stepKey: fillEmailFieldFindDeletedSubscriber
		$I->click("//*[@class='admin__filter-actions']//*[text()='Search']"); // stepKey: clickSearchButtonFindDeletedSubscriber
		$I->waitForPageLoad(30); // stepKey: waitForResultsLoadingFindDeletedSubscriber
		$I->comment("Exiting Action Group [findDeletedSubscriber] AdminMarketingFindNewsletterSubscribersInGridActionGroup");
		$I->comment("Entering Action Group [dontSeeSubscriber] AssertAdminDeletedNewsletterSubscriberIsNotInGridActionGroup");
		$I->dontSee(msq("Simple_US_Customer") . "John.Doe@example.com", "//table[contains(@class, 'data-grid')]/tbody/tr[1][@data-role='row']/td[@data-column='email']"); // stepKey: dontSeeSubscriberDontSeeSubscriber
		$I->comment("Exiting Action Group [dontSeeSubscriber] AssertAdminDeletedNewsletterSubscriberIsNotInGridActionGroup");
	}
}
