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
 * @Title("MC-14010: Captcha customer login page test")
 * @Description("Check CAPTCHA on Storefront Login Page.<h3>Test files</h3>app/code/Magento/Captcha/Test/Mftf/Test/StorefrontCaptchaOnCustomerLoginTest.xml<br>")
 * @TestCaseId("MC-14010")
 * @group captcha
 * @group mtf_migrated
 */
class StorefrontCaptchaOnCustomerLoginTestCest
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
		$setCaptchaLength = $I->magentoCLI("config:set customer/captcha/length 3", 60); // stepKey: setCaptchaLength
		$I->comment($setCaptchaLength);
		$setCaptchaSymbols = $I->magentoCLI("config:set customer/captcha/symbols 1", 60); // stepKey: setCaptchaSymbols
		$I->comment($setCaptchaSymbols);
		$I->comment("Entering Action Group [cleanInvalidatedCaches] CliCacheCleanActionGroup");
		$cleanSpecifiedCacheCleanInvalidatedCaches = $I->magentoCLI("cache:clean", 60, "config full_page"); // stepKey: cleanSpecifiedCacheCleanInvalidatedCaches
		$I->comment($cleanSpecifiedCacheCleanInvalidatedCaches);
		$I->comment("Exiting Action Group [cleanInvalidatedCaches] CliCacheCleanActionGroup");
		$I->createEntity("customer", "hook", "Simple_US_Customer", [], []); // stepKey: customer
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
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
	 * @Stories({"Login with Customer Account + Captcha"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StorefrontCaptchaOnCustomerLoginTest(AcceptanceTester $I)
	{
		$I->comment("Open storefront login form");
		$I->comment("Entering Action Group [goToSignInPage] StorefrontOpenCustomerLoginPageActionGroup");
		$I->amOnPage("/customer/account/login/"); // stepKey: amOnSignInPageGoToSignInPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadedGoToSignInPage
		$I->comment("Exiting Action Group [goToSignInPage] StorefrontOpenCustomerLoginPageActionGroup");
		$I->comment("Login with wrong credentials 3 times");
		$I->comment("Entering Action Group [fillLoginFormFirstAttempt] StorefrontFillCustomerLoginFormActionGroup");
		$I->fillField("#email", msq("Colorado_US_Customer") . "Patric.Patric@example.com"); // stepKey: fillEmailFillLoginFormFirstAttempt
		$I->fillField("#pass", "123123^q"); // stepKey: fillPasswordFillLoginFormFirstAttempt
		$I->comment("Exiting Action Group [fillLoginFormFirstAttempt] StorefrontFillCustomerLoginFormActionGroup");
		$I->comment("Entering Action Group [clickSignInAccountButtonFirstAttempt] StorefrontClickSignOnCustomerLoginFormActionGroup");
		$I->click("#send2"); // stepKey: clickSignInButtonClickSignInAccountButtonFirstAttempt
		$I->waitForPageLoad(30); // stepKey: clickSignInButtonClickSignInAccountButtonFirstAttemptWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCustomerSignInClickSignInAccountButtonFirstAttempt
		$I->comment("Exiting Action Group [clickSignInAccountButtonFirstAttempt] StorefrontClickSignOnCustomerLoginFormActionGroup");
		$I->comment("Entering Action Group [seeErrorMessageAfterFirstAttempt] AssertMessageCustomerLoginActionGroup");
		$I->see("The account sign-in was incorrect or your account is disabled temporarily. Please wait and try again later.", "#maincontent .message-error"); // stepKey: verifyMessageSeeErrorMessageAfterFirstAttempt
		$I->comment("Exiting Action Group [seeErrorMessageAfterFirstAttempt] AssertMessageCustomerLoginActionGroup");
		$I->comment("Entering Action Group [dontSeeCaptchaAfterFirstAttempt] AssertCaptchaNotVisibleOnCustomerLoginFormActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadedDontSeeCaptchaAfterFirstAttempt
		$I->dontSee("#captcha_user_login"); // stepKey: dontSeeCaptchaFieldDontSeeCaptchaAfterFirstAttempt
		$I->dontSee(".captcha-img"); // stepKey: dontSeeCaptchaImageDontSeeCaptchaAfterFirstAttempt
		$I->dontSee(".captcha-reload"); // stepKey: dontSeeCaptchaReloadButtonDontSeeCaptchaAfterFirstAttempt
		$I->reloadPage(); // stepKey: refreshPageDontSeeCaptchaAfterFirstAttempt
		$I->waitForPageLoad(30); // stepKey: waitForPageReloadedDontSeeCaptchaAfterFirstAttempt
		$I->dontSee("#captcha_user_login"); // stepKey: dontSeeCaptchaFieldAfterPageReloadDontSeeCaptchaAfterFirstAttempt
		$I->dontSee(".captcha-img"); // stepKey: dontSeeCaptchaImageAfterPageReloadDontSeeCaptchaAfterFirstAttempt
		$I->dontSee(".captcha-reload"); // stepKey: dontSeeCaptchaReloadButtonAfterPageReloadDontSeeCaptchaAfterFirstAttempt
		$I->comment("Exiting Action Group [dontSeeCaptchaAfterFirstAttempt] AssertCaptchaNotVisibleOnCustomerLoginFormActionGroup");
		$I->comment("Entering Action Group [fillLoginFormSecondAttempt] StorefrontFillCustomerLoginFormActionGroup");
		$I->fillField("#email", msq("Colorado_US_Customer") . "Patric.Patric@example.com"); // stepKey: fillEmailFillLoginFormSecondAttempt
		$I->fillField("#pass", "123123^q"); // stepKey: fillPasswordFillLoginFormSecondAttempt
		$I->comment("Exiting Action Group [fillLoginFormSecondAttempt] StorefrontFillCustomerLoginFormActionGroup");
		$I->comment("Entering Action Group [clickSignInAccountButtonSecondAttempt] StorefrontClickSignOnCustomerLoginFormActionGroup");
		$I->click("#send2"); // stepKey: clickSignInButtonClickSignInAccountButtonSecondAttempt
		$I->waitForPageLoad(30); // stepKey: clickSignInButtonClickSignInAccountButtonSecondAttemptWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCustomerSignInClickSignInAccountButtonSecondAttempt
		$I->comment("Exiting Action Group [clickSignInAccountButtonSecondAttempt] StorefrontClickSignOnCustomerLoginFormActionGroup");
		$I->comment("Entering Action Group [seeErrorMessageAfterSecondAttempt] AssertMessageCustomerLoginActionGroup");
		$I->see("The account sign-in was incorrect or your account is disabled temporarily. Please wait and try again later.", "#maincontent .message-error"); // stepKey: verifyMessageSeeErrorMessageAfterSecondAttempt
		$I->comment("Exiting Action Group [seeErrorMessageAfterSecondAttempt] AssertMessageCustomerLoginActionGroup");
		$I->comment("Entering Action Group [dontSeeCaptchaAfterSecondAttempt] AssertCaptchaNotVisibleOnCustomerLoginFormActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadedDontSeeCaptchaAfterSecondAttempt
		$I->dontSee("#captcha_user_login"); // stepKey: dontSeeCaptchaFieldDontSeeCaptchaAfterSecondAttempt
		$I->dontSee(".captcha-img"); // stepKey: dontSeeCaptchaImageDontSeeCaptchaAfterSecondAttempt
		$I->dontSee(".captcha-reload"); // stepKey: dontSeeCaptchaReloadButtonDontSeeCaptchaAfterSecondAttempt
		$I->reloadPage(); // stepKey: refreshPageDontSeeCaptchaAfterSecondAttempt
		$I->waitForPageLoad(30); // stepKey: waitForPageReloadedDontSeeCaptchaAfterSecondAttempt
		$I->dontSee("#captcha_user_login"); // stepKey: dontSeeCaptchaFieldAfterPageReloadDontSeeCaptchaAfterSecondAttempt
		$I->dontSee(".captcha-img"); // stepKey: dontSeeCaptchaImageAfterPageReloadDontSeeCaptchaAfterSecondAttempt
		$I->dontSee(".captcha-reload"); // stepKey: dontSeeCaptchaReloadButtonAfterPageReloadDontSeeCaptchaAfterSecondAttempt
		$I->comment("Exiting Action Group [dontSeeCaptchaAfterSecondAttempt] AssertCaptchaNotVisibleOnCustomerLoginFormActionGroup");
		$I->comment("Entering Action Group [fillLoginFormThirdAttempt] StorefrontFillCustomerLoginFormActionGroup");
		$I->fillField("#email", msq("Colorado_US_Customer") . "Patric.Patric@example.com"); // stepKey: fillEmailFillLoginFormThirdAttempt
		$I->fillField("#pass", "123123^q"); // stepKey: fillPasswordFillLoginFormThirdAttempt
		$I->comment("Exiting Action Group [fillLoginFormThirdAttempt] StorefrontFillCustomerLoginFormActionGroup");
		$I->comment("Entering Action Group [clickSignInAccountButtonThirdAttempt] StorefrontClickSignOnCustomerLoginFormActionGroup");
		$I->click("#send2"); // stepKey: clickSignInButtonClickSignInAccountButtonThirdAttempt
		$I->waitForPageLoad(30); // stepKey: clickSignInButtonClickSignInAccountButtonThirdAttemptWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCustomerSignInClickSignInAccountButtonThirdAttempt
		$I->comment("Exiting Action Group [clickSignInAccountButtonThirdAttempt] StorefrontClickSignOnCustomerLoginFormActionGroup");
		$I->comment("Entering Action Group [seeErrorMessageAfterThirdAttempt] AssertMessageCustomerLoginActionGroup");
		$I->see("The account sign-in was incorrect or your account is disabled temporarily. Please wait and try again later.", "#maincontent .message-error"); // stepKey: verifyMessageSeeErrorMessageAfterThirdAttempt
		$I->comment("Exiting Action Group [seeErrorMessageAfterThirdAttempt] AssertMessageCustomerLoginActionGroup");
		$I->comment("Entering Action Group [seeCaptchaAfterThirdAttempt] AssertCaptchaVisibleOnCustomerLoginFormActionGroup");
		$I->waitForElementVisible("#captcha_user_login", 30); // stepKey: waitToSeeCaptchaFieldSeeCaptchaAfterThirdAttempt
		$I->waitForElementVisible(".captcha-img", 30); // stepKey: waitToSeeCaptchaImageSeeCaptchaAfterThirdAttempt
		$I->waitForElementVisible(".captcha-reload", 30); // stepKey: waitToSeeCaptchaReloadButtonSeeCaptchaAfterThirdAttempt
		$I->reloadPage(); // stepKey: refreshPageSeeCaptchaAfterThirdAttempt
		$I->waitForPageLoad(30); // stepKey: waitForPageReloadedSeeCaptchaAfterThirdAttempt
		$I->waitForElementVisible("#captcha_user_login", 30); // stepKey: waitToSeeCaptchaFieldAfterPageReloadSeeCaptchaAfterThirdAttempt
		$I->waitForElementVisible(".captcha-img", 30); // stepKey: waitToSeeCaptchaImageAfterPageReloadSeeCaptchaAfterThirdAttempt
		$I->waitForElementVisible(".captcha-reload", 30); // stepKey: waitToSeeCaptchaReloadButtonAfterPageReloadSeeCaptchaAfterThirdAttempt
		$I->comment("Exiting Action Group [seeCaptchaAfterThirdAttempt] AssertCaptchaVisibleOnCustomerLoginFormActionGroup");
		$I->comment("Submit form with incorrect captcha");
		$I->comment("Entering Action Group [fillLoginFormCorrectAccountIncorrectCaptcha] StorefrontFillCustomerLoginFormWithCaptchaActionGroup");
		$I->fillField("#email", $I->retrieveEntityField('customer', 'email', 'test')); // stepKey: fillEmailFillLoginFormCorrectAccountIncorrectCaptcha
		$I->fillField("#pass", $I->retrieveEntityField('customer', 'password', 'test')); // stepKey: fillPasswordFillLoginFormCorrectAccountIncorrectCaptcha
		$I->fillField("#captcha_user_login", "WrongCAPTCHA" . msq("WrongCaptcha")); // stepKey: fillCaptchaFieldFillLoginFormCorrectAccountIncorrectCaptcha
		$I->comment("Exiting Action Group [fillLoginFormCorrectAccountIncorrectCaptcha] StorefrontFillCustomerLoginFormWithCaptchaActionGroup");
		$I->comment("Entering Action Group [clickSignInAccountButtonCorrectAccountIncorrectCaptcha] StorefrontClickSignOnCustomerLoginFormActionGroup");
		$I->click("#send2"); // stepKey: clickSignInButtonClickSignInAccountButtonCorrectAccountIncorrectCaptcha
		$I->waitForPageLoad(30); // stepKey: clickSignInButtonClickSignInAccountButtonCorrectAccountIncorrectCaptchaWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCustomerSignInClickSignInAccountButtonCorrectAccountIncorrectCaptcha
		$I->comment("Exiting Action Group [clickSignInAccountButtonCorrectAccountIncorrectCaptcha] StorefrontClickSignOnCustomerLoginFormActionGroup");
		$I->comment("Entering Action Group [seeErrorMessageAfterIncorrectCaptcha] AssertMessageCustomerLoginActionGroup");
		$I->see("Incorrect CAPTCHA", "#maincontent .message-error"); // stepKey: verifyMessageSeeErrorMessageAfterIncorrectCaptcha
		$I->comment("Exiting Action Group [seeErrorMessageAfterIncorrectCaptcha] AssertMessageCustomerLoginActionGroup");
		$I->comment("Entering Action Group [fillLoginFormCorrectAccountCorrectCaptcha] StorefrontFillCustomerLoginFormWithCaptchaActionGroup");
		$I->fillField("#email", $I->retrieveEntityField('customer', 'email', 'test')); // stepKey: fillEmailFillLoginFormCorrectAccountCorrectCaptcha
		$I->fillField("#pass", $I->retrieveEntityField('customer', 'password', 'test')); // stepKey: fillPasswordFillLoginFormCorrectAccountCorrectCaptcha
		$I->fillField("#captcha_user_login", "111"); // stepKey: fillCaptchaFieldFillLoginFormCorrectAccountCorrectCaptcha
		$I->comment("Exiting Action Group [fillLoginFormCorrectAccountCorrectCaptcha] StorefrontFillCustomerLoginFormWithCaptchaActionGroup");
		$I->comment("Entering Action Group [clickSignInAccountButtonCorrectAccountCorrectCaptcha] StorefrontClickSignOnCustomerLoginFormActionGroup");
		$I->click("#send2"); // stepKey: clickSignInButtonClickSignInAccountButtonCorrectAccountCorrectCaptcha
		$I->waitForPageLoad(30); // stepKey: clickSignInButtonClickSignInAccountButtonCorrectAccountCorrectCaptchaWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCustomerSignInClickSignInAccountButtonCorrectAccountCorrectCaptcha
		$I->comment("Exiting Action Group [clickSignInAccountButtonCorrectAccountCorrectCaptcha] StorefrontClickSignOnCustomerLoginFormActionGroup");
		$I->comment("Entering Action Group [assertCustomerLoggedIn] AssertCustomerWelcomeMessageActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAssertCustomerLoggedIn
		$I->see("Welcome, " . $I->retrieveEntityField('customer', 'firstname', 'test') . " " . $I->retrieveEntityField('customer', 'lastname', 'test') . "!", "header>.panel .greet.welcome"); // stepKey: verifyMessageAssertCustomerLoggedIn
		$I->comment("Exiting Action Group [assertCustomerLoggedIn] AssertCustomerWelcomeMessageActionGroup");
	}
}
