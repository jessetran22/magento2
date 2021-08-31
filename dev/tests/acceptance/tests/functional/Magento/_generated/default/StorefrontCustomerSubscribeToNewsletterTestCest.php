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
 * @Title("[NO TESTCASEID]: StoreFront Customer Newsletter Subscription")
 * @Description("Customer can be subscribed to Newsletter Subscription on StoreFront<h3>Test files</h3>app/code/Magento/Customer/Test/Mftf/Test/StorefrontCustomerSubscribeToNewsletterTest.xml<br>")
 */
class StorefrontCustomerSubscribeToNewsletterTestCest
{
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
	 * @Features({"Customer"})
	 * @Stories({"Subscribe To Newsletter Subscription on StoreFront"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StorefrontCustomerSubscribeToNewsletterTest(AcceptanceTester $I)
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
		$I->comment("Entering Action Group [assertMessage] AssertStorefrontCustomerMessagesActionGroup");
		$I->waitForElementVisible(".message-success", 30); // stepKey: waitForElementAssertMessage
		$I->see("We have saved your subscription.", ".message-success"); // stepKey: seeMessageAssertMessage
		$I->comment("Exiting Action Group [assertMessage] AssertStorefrontCustomerMessagesActionGroup");
	}
}
