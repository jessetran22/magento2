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
 * @Title("MC-14013: Test for checking captcha on the customer account edit page.")
 * @Description("Test for checking captcha on the customer account edit page and customer is locked.<h3>Test files</h3>app/code/Magento/Captcha/Test/Mftf/Test/StorefrontCaptchaEditCustomerEmailTest.xml<br>")
 * @TestCaseId("MC-14013")
 * @group captcha
 * @group mtf_migrated
 */
class StorefrontCaptchaEditCustomerEmailTestCest
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
		$I->comment("Setup CAPTCHA for testing");
		$enableUserEditCaptcha = $I->magentoCLI("config:set customer/captcha/forms user_edit", 60); // stepKey: enableUserEditCaptcha
		$I->comment($enableUserEditCaptcha);
		$setCaptchaLength = $I->magentoCLI("config:set customer/captcha/length 3", 60); // stepKey: setCaptchaLength
		$I->comment($setCaptchaLength);
		$setCaptchaSymbols = $I->magentoCLI("config:set customer/captcha/symbols 1", 60); // stepKey: setCaptchaSymbols
		$I->comment($setCaptchaSymbols);
		$I->comment("Entering Action Group [cleanInvalidatedCaches] CliCacheCleanActionGroup");
		$cleanSpecifiedCacheCleanInvalidatedCaches = $I->magentoCLI("cache:clean", 60, "config full_page"); // stepKey: cleanSpecifiedCacheCleanInvalidatedCaches
		$I->comment($cleanSpecifiedCacheCleanInvalidatedCaches);
		$I->comment("Exiting Action Group [cleanInvalidatedCaches] CliCacheCleanActionGroup");
		$I->createEntity("customer", "hook", "Simple_US_Customer", [], []); // stepKey: customer
		$I->comment("Sign in as customer");
		$I->comment("Entering Action Group [loginToStorefrontAccount] LoginToStorefrontActionGroup");
		$I->amOnPage("/customer/account/login/"); // stepKey: amOnSignInPageLoginToStorefrontAccount
		$I->waitForPageLoad(30); // stepKey: waitPageFullyLoadedLoginToStorefrontAccount
		$I->waitForElementVisible("#email", 30); // stepKey: waitFormAppearsLoginToStorefrontAccount
		$I->fillField("#email", $I->retrieveEntityField('customer', 'email', 'hook')); // stepKey: fillEmailLoginToStorefrontAccount
		$I->fillField("#pass", $I->retrieveEntityField('customer', 'password', 'hook')); // stepKey: fillPasswordLoginToStorefrontAccount
		$I->click("#send2"); // stepKey: clickSignInAccountButtonLoginToStorefrontAccount
		$I->waitForPageLoad(30); // stepKey: clickSignInAccountButtonLoginToStorefrontAccountWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCustomerLoggedInLoginToStorefrontAccount
		$I->comment("Exiting Action Group [loginToStorefrontAccount] LoginToStorefrontActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Revert Captcha forms configurations");
		$enableCaptchaOnDefaultForms = $I->magentoCLI("config:set customer/captcha/forms user_login,user_forgotpassword", 60); // stepKey: enableCaptchaOnDefaultForms
		$I->comment($enableCaptchaOnDefaultForms);
		$setDefaultCaptchaLength = $I->magentoCLI("config:set customer/captcha/length 4-5", 60); // stepKey: setDefaultCaptchaLength
		$I->comment($setDefaultCaptchaLength);
		$setDefaultCaptchaSymbols = $I->magentoCLI("config:set customer/captcha/symbols ABCDEFGHJKMnpqrstuvwxyz23456789", 60); // stepKey: setDefaultCaptchaSymbols
		$I->comment($setDefaultCaptchaSymbols);
		$I->comment("Entering Action Group [cleanInvalidatedCaches] CliCacheCleanActionGroup");
		$cleanSpecifiedCacheCleanInvalidatedCaches = $I->magentoCLI("cache:clean", 60, "config full_page"); // stepKey: cleanSpecifiedCacheCleanInvalidatedCaches
		$I->comment($cleanSpecifiedCacheCleanInvalidatedCaches);
		$I->comment("Exiting Action Group [cleanInvalidatedCaches] CliCacheCleanActionGroup");
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
	 * @Features({"Captcha"})
	 * @Stories({"Customer Account Info Edit + Captcha"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StorefrontCaptchaEditCustomerEmailTest(AcceptanceTester $I)
	{
		$I->comment("Open Customer edit page");
		$I->comment("Entering Action Group [goToCustomerEditPage] StorefrontOpenCustomerAccountInfoEditPageActionGroup");
		$I->amOnPage("/customer/account/edit/"); // stepKey: goToCustomerEditPageGoToCustomerEditPage
		$I->waitForPageLoad(30); // stepKey: waitForEditPageGoToCustomerEditPage
		$I->comment("Exiting Action Group [goToCustomerEditPage] StorefrontOpenCustomerAccountInfoEditPageActionGroup");
		$I->comment("Update email with incorrect password 3 times.");
		$I->comment("Entering Action Group [changeEmailFirstAttempt] StorefrontCustomerChangeEmailActionGroup");
		$I->conditionalClick("//div[@id='block-collapsible-nav']//a[text()='Account Information']", "//div[@id='block-collapsible-nav']//a[text()='Account Information']", true); // stepKey: openAccountInfoTabChangeEmailFirstAttempt
		$I->waitForPageLoad(60); // stepKey: openAccountInfoTabChangeEmailFirstAttemptWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForAccountInfoTabOpenedChangeEmailFirstAttempt
		$I->checkOption(".form-edit-account input[name='change_email']"); // stepKey: clickChangeEmailCheckboxChangeEmailFirstAttempt
		$I->fillField(".form-edit-account input[name='email']", $I->retrieveEntityField('customer', 'email', 'test')); // stepKey: fillEmailChangeEmailFirstAttempt
		$I->fillField("#current-password", "123123^q"); // stepKey: fillCurrentPasswordChangeEmailFirstAttempt
		$I->click("#form-validate .action.save.primary"); // stepKey: saveChangeChangeEmailFirstAttempt
		$I->waitForPageLoad(30); // stepKey: saveChangeChangeEmailFirstAttemptWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadedChangeEmailFirstAttempt
		$I->comment("Exiting Action Group [changeEmailFirstAttempt] StorefrontCustomerChangeEmailActionGroup");
		$I->comment("Entering Action Group [assertAccountMessageFirstAttempt] AssertMessageCustomerChangeAccountInfoActionGroup");
		$I->see("The password doesn't match this account. Verify the password and try again.", "#maincontent .message-error"); // stepKey: verifyMessageAssertAccountMessageFirstAttempt
		$I->comment("Exiting Action Group [assertAccountMessageFirstAttempt] AssertMessageCustomerChangeAccountInfoActionGroup");
		$I->comment("Entering Action Group [changeEmailSecondAttempt] StorefrontCustomerChangeEmailActionGroup");
		$I->conditionalClick("//div[@id='block-collapsible-nav']//a[text()='Account Information']", "//div[@id='block-collapsible-nav']//a[text()='Account Information']", true); // stepKey: openAccountInfoTabChangeEmailSecondAttempt
		$I->waitForPageLoad(60); // stepKey: openAccountInfoTabChangeEmailSecondAttemptWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForAccountInfoTabOpenedChangeEmailSecondAttempt
		$I->checkOption(".form-edit-account input[name='change_email']"); // stepKey: clickChangeEmailCheckboxChangeEmailSecondAttempt
		$I->fillField(".form-edit-account input[name='email']", $I->retrieveEntityField('customer', 'email', 'test')); // stepKey: fillEmailChangeEmailSecondAttempt
		$I->fillField("#current-password", "123123^q"); // stepKey: fillCurrentPasswordChangeEmailSecondAttempt
		$I->click("#form-validate .action.save.primary"); // stepKey: saveChangeChangeEmailSecondAttempt
		$I->waitForPageLoad(30); // stepKey: saveChangeChangeEmailSecondAttemptWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadedChangeEmailSecondAttempt
		$I->comment("Exiting Action Group [changeEmailSecondAttempt] StorefrontCustomerChangeEmailActionGroup");
		$I->comment("Entering Action Group [assertAccountMessageSecondAttempt] AssertMessageCustomerChangeAccountInfoActionGroup");
		$I->see("The password doesn't match this account. Verify the password and try again.", "#maincontent .message-error"); // stepKey: verifyMessageAssertAccountMessageSecondAttempt
		$I->comment("Exiting Action Group [assertAccountMessageSecondAttempt] AssertMessageCustomerChangeAccountInfoActionGroup");
		$I->comment("Entering Action Group [changeEmailThirdAttempt] StorefrontCustomerChangeEmailActionGroup");
		$I->conditionalClick("//div[@id='block-collapsible-nav']//a[text()='Account Information']", "//div[@id='block-collapsible-nav']//a[text()='Account Information']", true); // stepKey: openAccountInfoTabChangeEmailThirdAttempt
		$I->waitForPageLoad(60); // stepKey: openAccountInfoTabChangeEmailThirdAttemptWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForAccountInfoTabOpenedChangeEmailThirdAttempt
		$I->checkOption(".form-edit-account input[name='change_email']"); // stepKey: clickChangeEmailCheckboxChangeEmailThirdAttempt
		$I->fillField(".form-edit-account input[name='email']", $I->retrieveEntityField('customer', 'email', 'test')); // stepKey: fillEmailChangeEmailThirdAttempt
		$I->fillField("#current-password", "123123^q"); // stepKey: fillCurrentPasswordChangeEmailThirdAttempt
		$I->click("#form-validate .action.save.primary"); // stepKey: saveChangeChangeEmailThirdAttempt
		$I->waitForPageLoad(30); // stepKey: saveChangeChangeEmailThirdAttemptWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadedChangeEmailThirdAttempt
		$I->comment("Exiting Action Group [changeEmailThirdAttempt] StorefrontCustomerChangeEmailActionGroup");
		$I->comment("Entering Action Group [assertAccountMessageThirdAttempt] AssertMessageCustomerChangeAccountInfoActionGroup");
		$I->see("The password doesn't match this account. Verify the password and try again.", "#maincontent .message-error"); // stepKey: verifyMessageAssertAccountMessageThirdAttempt
		$I->comment("Exiting Action Group [assertAccountMessageThirdAttempt] AssertMessageCustomerChangeAccountInfoActionGroup");
		$I->comment("Check captcha visibility after incorrect password submit form");
		$I->comment("Entering Action Group [assertCaptchaVisible] AssertCaptchaVisibleOnCustomerAccountInfoActionGroup");
		$I->checkOption(".form-edit-account input[name='change_email']"); // stepKey: clickChangeEmailCheckboxAssertCaptchaVisible
		$I->waitForElementVisible("#captcha_user_edit", 30); // stepKey: seeCaptchaFieldAssertCaptchaVisible
		$I->waitForElementVisible(".captcha-img", 30); // stepKey: seeCaptchaImageAssertCaptchaVisible
		$I->waitForElementVisible(".captcha-reload", 30); // stepKey: seeCaptchaReloadButtonAssertCaptchaVisible
		$I->reloadPage(); // stepKey: refreshPageAssertCaptchaVisible
		$I->waitForPageLoad(30); // stepKey: waitForPageReloadedAssertCaptchaVisible
		$I->checkOption(".form-edit-account input[name='change_email']"); // stepKey: clickChangeEmailCheckboxAfterPageReloadAssertCaptchaVisible
		$I->waitForElementVisible("#captcha_user_edit", 30); // stepKey: seeCaptchaFieldAfterPageReloadAssertCaptchaVisible
		$I->waitForElementVisible(".captcha-img", 30); // stepKey: seeCaptchaImageAfterPageReloadAssertCaptchaVisible
		$I->waitForElementVisible(".captcha-reload", 30); // stepKey: seeCaptchaReloadButtonAfterPageReloadAssertCaptchaVisible
		$I->comment("Exiting Action Group [assertCaptchaVisible] AssertCaptchaVisibleOnCustomerAccountInfoActionGroup");
		$I->comment("Try to submit form with incorrect captcha");
		$I->comment("Entering Action Group [changeEmailWithIncorrectCaptcha] StorefrontCustomerChangeEmailWithCaptchaActionGroup");
		$I->conditionalClick("//div[@id='block-collapsible-nav']//a[text()='Account Information']", "//div[@id='block-collapsible-nav']//a[text()='Account Information']", true); // stepKey: openAccountInfoTabChangeEmailWithIncorrectCaptcha
		$I->waitForPageLoad(60); // stepKey: openAccountInfoTabChangeEmailWithIncorrectCaptchaWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForAccountInfoTabOpenedChangeEmailWithIncorrectCaptcha
		$I->checkOption(".form-edit-account input[name='change_email']"); // stepKey: clickChangeEmailCheckboxChangeEmailWithIncorrectCaptcha
		$I->fillField(".form-edit-account input[name='email']", $I->retrieveEntityField('customer', 'email', 'test')); // stepKey: fillEmailChangeEmailWithIncorrectCaptcha
		$I->fillField("#current-password", "123123^q"); // stepKey: fillCurrentPasswordChangeEmailWithIncorrectCaptcha
		$I->fillField("#captcha_user_edit", "WrongCAPTCHA" . msq("WrongCaptcha")); // stepKey: fillCaptchaFieldChangeEmailWithIncorrectCaptcha
		$I->click("#form-validate .action.save.primary"); // stepKey: saveChangeChangeEmailWithIncorrectCaptcha
		$I->waitForPageLoad(30); // stepKey: saveChangeChangeEmailWithIncorrectCaptchaWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadedChangeEmailWithIncorrectCaptcha
		$I->comment("Exiting Action Group [changeEmailWithIncorrectCaptcha] StorefrontCustomerChangeEmailWithCaptchaActionGroup");
		$I->comment("Entering Action Group [assertAccountMessageAfterIncorrectCaptcha] AssertMessageCustomerChangeAccountInfoActionGroup");
		$I->see("Incorrect CAPTCHA", "#maincontent .message-error"); // stepKey: verifyMessageAssertAccountMessageAfterIncorrectCaptcha
		$I->comment("Exiting Action Group [assertAccountMessageAfterIncorrectCaptcha] AssertMessageCustomerChangeAccountInfoActionGroup");
		$I->comment("Update customer email correct password and CAPTCHA");
		$I->comment("Entering Action Group [changeEmailCorrectAttempt] StorefrontCustomerChangeEmailWithCaptchaActionGroup");
		$I->conditionalClick("//div[@id='block-collapsible-nav']//a[text()='Account Information']", "//div[@id='block-collapsible-nav']//a[text()='Account Information']", true); // stepKey: openAccountInfoTabChangeEmailCorrectAttempt
		$I->waitForPageLoad(60); // stepKey: openAccountInfoTabChangeEmailCorrectAttemptWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForAccountInfoTabOpenedChangeEmailCorrectAttempt
		$I->checkOption(".form-edit-account input[name='change_email']"); // stepKey: clickChangeEmailCheckboxChangeEmailCorrectAttempt
		$I->fillField(".form-edit-account input[name='email']", $I->retrieveEntityField('customer', 'email', 'test')); // stepKey: fillEmailChangeEmailCorrectAttempt
		$I->fillField("#current-password", $I->retrieveEntityField('customer', 'password', 'test')); // stepKey: fillCurrentPasswordChangeEmailCorrectAttempt
		$I->fillField("#captcha_user_edit", "111"); // stepKey: fillCaptchaFieldChangeEmailCorrectAttempt
		$I->click("#form-validate .action.save.primary"); // stepKey: saveChangeChangeEmailCorrectAttempt
		$I->waitForPageLoad(30); // stepKey: saveChangeChangeEmailCorrectAttemptWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadedChangeEmailCorrectAttempt
		$I->comment("Exiting Action Group [changeEmailCorrectAttempt] StorefrontCustomerChangeEmailWithCaptchaActionGroup");
		$I->comment("Entering Action Group [assertAccountMessageCorrectAttempt] AssertMessageCustomerChangeAccountInfoActionGroup");
		$I->see("You saved the account information.", "#maincontent .message-success"); // stepKey: verifyMessageAssertAccountMessageCorrectAttempt
		$I->comment("Exiting Action Group [assertAccountMessageCorrectAttempt] AssertMessageCustomerChangeAccountInfoActionGroup");
	}
}
