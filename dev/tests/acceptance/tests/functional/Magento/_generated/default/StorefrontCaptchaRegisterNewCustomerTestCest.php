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
 * @Title("MC-14805: Test creation for customer register with captcha on storefront.")
 * @Description("Test creation for customer register with captcha on storefront.<h3>Test files</h3>app/code/Magento/Captcha/Test/Mftf/Test/StorefrontCaptchaRegisterNewCustomerTest.xml<br>")
 * @TestCaseId("MC-14805")
 * @group captcha
 * @group mtf_migrated
 */
class StorefrontCaptchaRegisterNewCustomerTestCest
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
		$I->comment("Enable captcha for customer.");
		$enableUserRegistrationCaptcha = $I->magentoCLI("config:set customer/captcha/forms user_create", 60); // stepKey: enableUserRegistrationCaptcha
		$I->comment($enableUserRegistrationCaptcha);
		$alwaysEnableCaptcha = $I->magentoCLI("config:set customer/captcha/mode always", 60); // stepKey: alwaysEnableCaptcha
		$I->comment($alwaysEnableCaptcha);
		$setCaptchaLength = $I->magentoCLI("config:set customer/captcha/length 3", 60); // stepKey: setCaptchaLength
		$I->comment($setCaptchaLength);
		$setCaptchaSymbols = $I->magentoCLI("config:set customer/captcha/symbols 1", 60); // stepKey: setCaptchaSymbols
		$I->comment($setCaptchaSymbols);
		$I->comment("Entering Action Group [cleanInvalidatedCaches] CliCacheCleanActionGroup");
		$cleanSpecifiedCacheCleanInvalidatedCaches = $I->magentoCLI("cache:clean", 60, "config full_page"); // stepKey: cleanSpecifiedCacheCleanInvalidatedCaches
		$I->comment($cleanSpecifiedCacheCleanInvalidatedCaches);
		$I->comment("Exiting Action Group [cleanInvalidatedCaches] CliCacheCleanActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Set default configuration.");
		$enableCaptchaOnDefaultForms = $I->magentoCLI("config:set customer/captcha/forms user_login,user_forgotpassword", 60); // stepKey: enableCaptchaOnDefaultForms
		$I->comment($enableCaptchaOnDefaultForms);
		$defaultCaptchaMode = $I->magentoCLI("config:set customer/captcha/mode after_fail", 60); // stepKey: defaultCaptchaMode
		$I->comment($defaultCaptchaMode);
		$setDefaultCaptchaLength = $I->magentoCLI("config:set customer/captcha/length 4-5", 60); // stepKey: setDefaultCaptchaLength
		$I->comment($setDefaultCaptchaLength);
		$setDefaultCaptchaSymbols = $I->magentoCLI("config:set customer/captcha/symbols ABCDEFGHJKMnpqrstuvwxyz23456789", 60); // stepKey: setDefaultCaptchaSymbols
		$I->comment($setDefaultCaptchaSymbols);
		$I->comment("Entering Action Group [cleanInvalidatedCaches] CliCacheCleanActionGroup");
		$cleanSpecifiedCacheCleanInvalidatedCaches = $I->magentoCLI("cache:clean", 60, "config full_page"); // stepKey: cleanSpecifiedCacheCleanInvalidatedCaches
		$I->comment($cleanSpecifiedCacheCleanInvalidatedCaches);
		$I->comment("Exiting Action Group [cleanInvalidatedCaches] CliCacheCleanActionGroup");
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
	 * @Stories({"Create New Customer Account + Captcha"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StorefrontCaptchaRegisterNewCustomerTest(AcceptanceTester $I)
	{
		$I->comment("Open Customer registration page");
		$I->comment("Entering Action Group [goToCustomerAccountCreatePage] StorefrontOpenCustomerAccountCreatePageActionGroup");
		$I->amOnPage("/customer/account/create/"); // stepKey: goToCustomerAccountCreatePageGoToCustomerAccountCreatePage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadedGoToCustomerAccountCreatePage
		$I->comment("Exiting Action Group [goToCustomerAccountCreatePage] StorefrontOpenCustomerAccountCreatePageActionGroup");
		$I->comment("Check captcha visibility registration page load");
		$I->comment("Entering Action Group [verifyCaptchaVisible] AssertCaptchaVisibleOnCustomerAccountCreatePageActionGroup");
		$I->waitForElementVisible("#captcha_user_create", 30); // stepKey: waitForCaptchaFieldVerifyCaptchaVisible
		$I->waitForElementVisible(".captcha-img", 30); // stepKey: waitForCaptchaImageVerifyCaptchaVisible
		$I->waitForElementVisible(".captcha-reload", 30); // stepKey: waitForCaptchaReloadButtonVerifyCaptchaVisible
		$I->comment("Exiting Action Group [verifyCaptchaVisible] AssertCaptchaVisibleOnCustomerAccountCreatePageActionGroup");
		$I->comment("Submit form with incorrect captcha");
		$I->comment("Entering Action Group [fillNewCustomerAccountFormWithIncorrectCaptcha] StorefrontFillCustomerAccountCreationFormWithCaptchaActionGroup");
		$I->fillField("#firstname", "John"); // stepKey: fillFirstNameFillNewCustomerAccountFormWithIncorrectCaptcha
		$I->fillField("#lastname", "Doe"); // stepKey: fillLastNameFillNewCustomerAccountFormWithIncorrectCaptcha
		$I->fillField("#email_address", msq("Simple_US_Customer") . "John.Doe@example.com"); // stepKey: fillEmailFillNewCustomerAccountFormWithIncorrectCaptcha
		$I->fillField("#password", "pwdTest123!"); // stepKey: fillPasswordFillNewCustomerAccountFormWithIncorrectCaptcha
		$I->fillField("#password-confirmation", "pwdTest123!"); // stepKey: fillConfirmPasswordFillNewCustomerAccountFormWithIncorrectCaptcha
		$I->fillField("#captcha_user_create", "WrongCAPTCHA" . msq("WrongCaptcha")); // stepKey: fillCaptchaFieldFillNewCustomerAccountFormWithIncorrectCaptcha
		$I->comment("Exiting Action Group [fillNewCustomerAccountFormWithIncorrectCaptcha] StorefrontFillCustomerAccountCreationFormWithCaptchaActionGroup");
		$I->comment("Entering Action Group [clickCreateAnAccountButton] StorefrontClickCreateAnAccountCustomerAccountCreationFormActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForCreateAccountButtonIsActiveClickCreateAnAccountButton
		$I->click("button.action.submit.primary"); // stepKey: clickCreateAccountButtonClickCreateAnAccountButton
		$I->waitForPageLoad(30); // stepKey: clickCreateAccountButtonClickCreateAnAccountButtonWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCustomerSavedClickCreateAnAccountButton
		$I->comment("Exiting Action Group [clickCreateAnAccountButton] StorefrontClickCreateAnAccountCustomerAccountCreationFormActionGroup");
		$I->comment("Entering Action Group [assertMessage] AssertMessageCustomerCreateAccountActionGroup");
		$I->see("Incorrect CAPTCHA", "#maincontent .message-error"); // stepKey: verifyMessageAssertMessage
		$I->comment("Exiting Action Group [assertMessage] AssertMessageCustomerCreateAccountActionGroup");
		$I->comment("Entering Action Group [verifyCaptchaVisibleAfterFail] AssertCaptchaVisibleOnCustomerAccountCreatePageActionGroup");
		$I->waitForElementVisible("#captcha_user_create", 30); // stepKey: waitForCaptchaFieldVerifyCaptchaVisibleAfterFail
		$I->waitForElementVisible(".captcha-img", 30); // stepKey: waitForCaptchaImageVerifyCaptchaVisibleAfterFail
		$I->waitForElementVisible(".captcha-reload", 30); // stepKey: waitForCaptchaReloadButtonVerifyCaptchaVisibleAfterFail
		$I->comment("Exiting Action Group [verifyCaptchaVisibleAfterFail] AssertCaptchaVisibleOnCustomerAccountCreatePageActionGroup");
		$I->comment("Submit form with correct captcha");
		$I->comment("Entering Action Group [fillNewCustomerAccountFormWithCorrectCaptcha] StorefrontFillCustomerAccountCreationFormWithCaptchaActionGroup");
		$I->fillField("#firstname", "John"); // stepKey: fillFirstNameFillNewCustomerAccountFormWithCorrectCaptcha
		$I->fillField("#lastname", "Doe"); // stepKey: fillLastNameFillNewCustomerAccountFormWithCorrectCaptcha
		$I->fillField("#email_address", msq("Simple_US_Customer") . "John.Doe@example.com"); // stepKey: fillEmailFillNewCustomerAccountFormWithCorrectCaptcha
		$I->fillField("#password", "pwdTest123!"); // stepKey: fillPasswordFillNewCustomerAccountFormWithCorrectCaptcha
		$I->fillField("#password-confirmation", "pwdTest123!"); // stepKey: fillConfirmPasswordFillNewCustomerAccountFormWithCorrectCaptcha
		$I->fillField("#captcha_user_create", "111"); // stepKey: fillCaptchaFieldFillNewCustomerAccountFormWithCorrectCaptcha
		$I->comment("Exiting Action Group [fillNewCustomerAccountFormWithCorrectCaptcha] StorefrontFillCustomerAccountCreationFormWithCaptchaActionGroup");
		$I->comment("Entering Action Group [clickCreateAnAccountButtonAfterCorrectCaptcha] StorefrontClickCreateAnAccountCustomerAccountCreationFormActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForCreateAccountButtonIsActiveClickCreateAnAccountButtonAfterCorrectCaptcha
		$I->click("button.action.submit.primary"); // stepKey: clickCreateAccountButtonClickCreateAnAccountButtonAfterCorrectCaptcha
		$I->waitForPageLoad(30); // stepKey: clickCreateAccountButtonClickCreateAnAccountButtonAfterCorrectCaptchaWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCustomerSavedClickCreateAnAccountButtonAfterCorrectCaptcha
		$I->comment("Exiting Action Group [clickCreateAnAccountButtonAfterCorrectCaptcha] StorefrontClickCreateAnAccountCustomerAccountCreationFormActionGroup");
		$I->comment("Entering Action Group [assertSuccessMessage] AssertMessageCustomerCreateAccountActionGroup");
		$I->see("Thank you for registering with Main Website Store.", "#maincontent .message-success"); // stepKey: verifyMessageAssertSuccessMessage
		$I->comment("Exiting Action Group [assertSuccessMessage] AssertMessageCustomerCreateAccountActionGroup");
	}
}
