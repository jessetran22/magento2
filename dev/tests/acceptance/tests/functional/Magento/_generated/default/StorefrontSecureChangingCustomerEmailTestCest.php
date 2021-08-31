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
 * @Title("MC-14385: Changing Customer Email Test")
 * @Description("Changing Customer's email with correct and wrong passwords<h3>Test files</h3>app/code/Magento/Security/Test/Mftf/Test/StorefrontSecureChangingCustomerEmailTest.xml<br>")
 * @TestCaseId("MC-14385")
 * @group security
 * @group mtf_migrated
 */
class StorefrontSecureChangingCustomerEmailTestCest
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
		$I->createEntity("customer", "hook", "Simple_US_Customer", [], []); // stepKey: customer
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [customerLogout] StorefrontCustomerLogoutActionGroup");
		$I->amOnPage("customer/account/logout/"); // stepKey: storefrontSignOutCustomerLogout
		$I->waitForPageLoad(30); // stepKey: waitForSignOutCustomerLogout
		$I->comment("Exiting Action Group [customerLogout] StorefrontCustomerLogoutActionGroup");
		$I->deleteEntity("customer", "hook"); // stepKey: deleteCustomer
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
	 * @Stories({"Changing Customer's email"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StorefrontSecureChangingCustomerEmailTest(AcceptanceTester $I)
	{
		$I->comment("Go to storefront home page");
		$I->comment("Entering Action Group [openStoreFrontHomePage] StorefrontOpenHomePageActionGroup");
		$I->amOnPage("/"); // stepKey: goToStorefrontPageOpenStoreFrontHomePage
		$I->waitForPageLoad(30); // stepKey: waitForStorefrontPageLoadOpenStoreFrontHomePage
		$I->comment("Exiting Action Group [openStoreFrontHomePage] StorefrontOpenHomePageActionGroup");
		$I->comment("Login as created customer");
		$I->comment("Entering Action Group [loginToStorefrontAccount] LoginToStorefrontActionGroup");
		$I->amOnPage("/customer/account/login/"); // stepKey: amOnSignInPageLoginToStorefrontAccount
		$I->waitForPageLoad(30); // stepKey: waitPageFullyLoadedLoginToStorefrontAccount
		$I->waitForElementVisible("#email", 30); // stepKey: waitFormAppearsLoginToStorefrontAccount
		$I->fillField("#email", $I->retrieveEntityField('customer', 'email', 'test')); // stepKey: fillEmailLoginToStorefrontAccount
		$I->fillField("#pass", $I->retrieveEntityField('customer', 'password', 'test')); // stepKey: fillPasswordLoginToStorefrontAccount
		$I->click("#send2"); // stepKey: clickSignInAccountButtonLoginToStorefrontAccount
		$I->waitForPageLoad(30); // stepKey: clickSignInAccountButtonLoginToStorefrontAccountWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCustomerLoggedInLoginToStorefrontAccount
		$I->comment("Exiting Action Group [loginToStorefrontAccount] LoginToStorefrontActionGroup");
		$I->comment("Navigate to \"Account Information\" tab First Time");
		$I->comment("Entering Action Group [goToCustomerEditPageFirstTime] StorefrontOpenCustomerAccountInfoEditPageActionGroup");
		$I->amOnPage("/customer/account/edit/"); // stepKey: goToCustomerEditPageGoToCustomerEditPageFirstTime
		$I->waitForPageLoad(30); // stepKey: waitForEditPageGoToCustomerEditPageFirstTime
		$I->comment("Exiting Action Group [goToCustomerEditPageFirstTime] StorefrontOpenCustomerAccountInfoEditPageActionGroup");
		$I->comment("Enter new email and save with correct password");
		$I->comment("Entering Action Group [changeEmailCorrectAttempt] StorefrontCustomerChangeEmailActionGroup");
		$I->conditionalClick("//div[@id='block-collapsible-nav']//a[text()='Account Information']", "//div[@id='block-collapsible-nav']//a[text()='Account Information']", true); // stepKey: openAccountInfoTabChangeEmailCorrectAttempt
		$I->waitForPageLoad(60); // stepKey: openAccountInfoTabChangeEmailCorrectAttemptWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForAccountInfoTabOpenedChangeEmailCorrectAttempt
		$I->checkOption(".form-edit-account input[name='change_email']"); // stepKey: clickChangeEmailCheckboxChangeEmailCorrectAttempt
		$I->fillField(".form-edit-account input[name='email']", $I->retrieveEntityField('customer', 'email', 'test')); // stepKey: fillEmailChangeEmailCorrectAttempt
		$I->fillField("#current-password", $I->retrieveEntityField('customer', 'password', 'test')); // stepKey: fillCurrentPasswordChangeEmailCorrectAttempt
		$I->click("#form-validate .action.save.primary"); // stepKey: saveChangeChangeEmailCorrectAttempt
		$I->waitForPageLoad(30); // stepKey: saveChangeChangeEmailCorrectAttemptWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadedChangeEmailCorrectAttempt
		$I->comment("Exiting Action Group [changeEmailCorrectAttempt] StorefrontCustomerChangeEmailActionGroup");
		$I->comment("See Success Notify");
		$I->comment("Entering Action Group [seeSuccessMessage] AssertMessageCustomerChangeAccountInfoActionGroup");
		$I->see("You saved the account information.", "#maincontent .message-success"); // stepKey: verifyMessageSeeSuccessMessage
		$I->comment("Exiting Action Group [seeSuccessMessage] AssertMessageCustomerChangeAccountInfoActionGroup");
		$I->see("Default welcome msg!", "header>.panel .greet.welcome"); // stepKey: assertWelcomeMessage
		$I->comment("Entering Action Group [loginToStorefrontAccountAfterEmailChange] LoginToStorefrontActionGroup");
		$I->amOnPage("/customer/account/login/"); // stepKey: amOnSignInPageLoginToStorefrontAccountAfterEmailChange
		$I->waitForPageLoad(30); // stepKey: waitPageFullyLoadedLoginToStorefrontAccountAfterEmailChange
		$I->waitForElementVisible("#email", 30); // stepKey: waitFormAppearsLoginToStorefrontAccountAfterEmailChange
		$I->fillField("#email", $I->retrieveEntityField('customer', 'email', 'test')); // stepKey: fillEmailLoginToStorefrontAccountAfterEmailChange
		$I->fillField("#pass", $I->retrieveEntityField('customer', 'password', 'test')); // stepKey: fillPasswordLoginToStorefrontAccountAfterEmailChange
		$I->click("#send2"); // stepKey: clickSignInAccountButtonLoginToStorefrontAccountAfterEmailChange
		$I->waitForPageLoad(30); // stepKey: clickSignInAccountButtonLoginToStorefrontAccountAfterEmailChangeWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCustomerLoggedInLoginToStorefrontAccountAfterEmailChange
		$I->comment("Exiting Action Group [loginToStorefrontAccountAfterEmailChange] LoginToStorefrontActionGroup");
		$I->comment("Navigate to \"Account Information\" tab Second Time");
		$I->comment("Entering Action Group [goToCustomerEditPageSecondTime] StorefrontOpenCustomerAccountInfoEditPageActionGroup");
		$I->amOnPage("/customer/account/edit/"); // stepKey: goToCustomerEditPageGoToCustomerEditPageSecondTime
		$I->waitForPageLoad(30); // stepKey: waitForEditPageGoToCustomerEditPageSecondTime
		$I->comment("Exiting Action Group [goToCustomerEditPageSecondTime] StorefrontOpenCustomerAccountInfoEditPageActionGroup");
		$I->comment("Enter new email and save with correct password");
		$I->comment("Entering Action Group [changeEmailWrongAttempt] StorefrontCustomerChangeEmailActionGroup");
		$I->conditionalClick("//div[@id='block-collapsible-nav']//a[text()='Account Information']", "//div[@id='block-collapsible-nav']//a[text()='Account Information']", true); // stepKey: openAccountInfoTabChangeEmailWrongAttempt
		$I->waitForPageLoad(60); // stepKey: openAccountInfoTabChangeEmailWrongAttemptWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForAccountInfoTabOpenedChangeEmailWrongAttempt
		$I->checkOption(".form-edit-account input[name='change_email']"); // stepKey: clickChangeEmailCheckboxChangeEmailWrongAttempt
		$I->fillField(".form-edit-account input[name='email']", $I->retrieveEntityField('customer', 'email', 'test')); // stepKey: fillEmailChangeEmailWrongAttempt
		$I->fillField("#current-password", "WRONG_PASSWORD_123123q"); // stepKey: fillCurrentPasswordChangeEmailWrongAttempt
		$I->click("#form-validate .action.save.primary"); // stepKey: saveChangeChangeEmailWrongAttempt
		$I->waitForPageLoad(30); // stepKey: saveChangeChangeEmailWrongAttemptWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadedChangeEmailWrongAttempt
		$I->comment("Exiting Action Group [changeEmailWrongAttempt] StorefrontCustomerChangeEmailActionGroup");
		$I->comment("See Failure Message");
		$I->comment("Entering Action Group [seeFailureMessage] AssertMessageCustomerChangeAccountInfoActionGroup");
		$I->see("The password doesn't match this account. Verify the password and try again.", "#maincontent .message-error"); // stepKey: verifyMessageSeeFailureMessage
		$I->comment("Exiting Action Group [seeFailureMessage] AssertMessageCustomerChangeAccountInfoActionGroup");
	}
}
