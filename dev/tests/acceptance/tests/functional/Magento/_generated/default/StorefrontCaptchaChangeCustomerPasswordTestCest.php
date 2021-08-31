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
 * @Title("[NO TESTCASEID]: Enabled captcha on changing customer password form")
 * @Description("Customer should be able change the password with enabled captcha<h3>Test files</h3>app/code/Magento/Captcha/Test/Mftf/Test/StorefrontCaptchaChangeCustomerPasswordTest.xml<br>")
 * @group captcha
 */
class StorefrontCaptchaChangeCustomerPasswordTestCest
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
		$enableUserEditCaptcha = $I->magentoCLI("config:set customer/captcha/forms user_edit", 60); // stepKey: enableUserEditCaptcha
		$I->comment($enableUserEditCaptcha);
		$setCaptchaLength = $I->magentoCLI("config:set customer/captcha/length 3", 60); // stepKey: setCaptchaLength
		$I->comment($setCaptchaLength);
		$setCaptchaSymbols = $I->magentoCLI("config:set customer/captcha/symbols 1", 60); // stepKey: setCaptchaSymbols
		$I->comment($setCaptchaSymbols);
		$setCaptchaAlwaysVisible = $I->magentoCLI("config:set customer/captcha/mode always", 60); // stepKey: setCaptchaAlwaysVisible
		$I->comment($setCaptchaAlwaysVisible);
		$I->comment("Entering Action Group [cleanInvalidatedCaches] CliCacheCleanActionGroup");
		$cleanSpecifiedCacheCleanInvalidatedCaches = $I->magentoCLI("cache:clean", 60, "config full_page"); // stepKey: cleanSpecifiedCacheCleanInvalidatedCaches
		$I->comment($cleanSpecifiedCacheCleanInvalidatedCaches);
		$I->comment("Exiting Action Group [cleanInvalidatedCaches] CliCacheCleanActionGroup");
		$I->createEntity("customer", "hook", "Simple_US_Customer", [], []); // stepKey: customer
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
		$enableCaptchaOnDefaultForms = $I->magentoCLI("config:set customer/captcha/forms user_login,user_forgotpassword", 60); // stepKey: enableCaptchaOnDefaultForms
		$I->comment($enableCaptchaOnDefaultForms);
		$setDefaultCaptchaLength = $I->magentoCLI("config:set customer/captcha/length 4-5", 60); // stepKey: setDefaultCaptchaLength
		$I->comment($setDefaultCaptchaLength);
		$setDefaultCaptchaSymbols = $I->magentoCLI("config:set customer/captcha/symbols ABCDEFGHJKMnpqrstuvwxyz23456789", 60); // stepKey: setDefaultCaptchaSymbols
		$I->comment($setDefaultCaptchaSymbols);
		$setCaptchaDefaultVisibility = $I->magentoCLI("config:set customer/captcha/mode after_fail", 60); // stepKey: setCaptchaDefaultVisibility
		$I->comment($setCaptchaDefaultVisibility);
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
	 * @Stories({"Change customer password with enabled captcha"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StorefrontCaptchaChangeCustomerPasswordTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [goToCustomerEditPage] StorefrontOpenCustomerAccountInfoEditPageActionGroup");
		$I->amOnPage("/customer/account/edit/"); // stepKey: goToCustomerEditPageGoToCustomerEditPage
		$I->waitForPageLoad(30); // stepKey: waitForEditPageGoToCustomerEditPage
		$I->comment("Exiting Action Group [goToCustomerEditPage] StorefrontOpenCustomerAccountInfoEditPageActionGroup");
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
		$I->comment("Entering Action Group [changePasswordWithIncorrectCaptcha] StorefrontCustomerChangePasswordWithCaptchaActionGroup");
		$I->checkOption(".form-edit-account input[name='change_password']"); // stepKey: clickChangePasswordCheckboxChangePasswordWithIncorrectCaptcha
		$I->fillField("#current-password", "pwdTest123!"); // stepKey: fillCurrentPasswordChangePasswordWithIncorrectCaptcha
		$I->fillField("#password", "123123^q"); // stepKey: fillNewPasswordChangePasswordWithIncorrectCaptcha
		$I->fillField("#password-confirmation", "123123^q"); // stepKey: confirmNewPasswordChangePasswordWithIncorrectCaptcha
		$I->fillField("#captcha_user_edit", "WrongCAPTCHA" . msq("WrongCaptcha")); // stepKey: fillCaptchaFieldChangePasswordWithIncorrectCaptcha
		$I->click("#form-validate .action.save.primary"); // stepKey: saveChangeChangePasswordWithIncorrectCaptcha
		$I->waitForPageLoad(30); // stepKey: saveChangeChangePasswordWithIncorrectCaptchaWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadedChangePasswordWithIncorrectCaptcha
		$I->comment("Exiting Action Group [changePasswordWithIncorrectCaptcha] StorefrontCustomerChangePasswordWithCaptchaActionGroup");
		$I->comment("Entering Action Group [assertErrorMessage] AssertMessageCustomerChangeAccountInfoActionGroup");
		$I->see("Incorrect CAPTCHA", "#maincontent .message-error"); // stepKey: verifyMessageAssertErrorMessage
		$I->comment("Exiting Action Group [assertErrorMessage] AssertMessageCustomerChangeAccountInfoActionGroup");
		$I->comment("Entering Action Group [changePasswordWithCorrectValues] StorefrontCustomerChangePasswordWithCaptchaActionGroup");
		$I->checkOption(".form-edit-account input[name='change_password']"); // stepKey: clickChangePasswordCheckboxChangePasswordWithCorrectValues
		$I->fillField("#current-password", "pwdTest123!"); // stepKey: fillCurrentPasswordChangePasswordWithCorrectValues
		$I->fillField("#password", "123123^q"); // stepKey: fillNewPasswordChangePasswordWithCorrectValues
		$I->fillField("#password-confirmation", "123123^q"); // stepKey: confirmNewPasswordChangePasswordWithCorrectValues
		$I->fillField("#captcha_user_edit", "111"); // stepKey: fillCaptchaFieldChangePasswordWithCorrectValues
		$I->click("#form-validate .action.save.primary"); // stepKey: saveChangeChangePasswordWithCorrectValues
		$I->waitForPageLoad(30); // stepKey: saveChangeChangePasswordWithCorrectValuesWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadedChangePasswordWithCorrectValues
		$I->comment("Exiting Action Group [changePasswordWithCorrectValues] StorefrontCustomerChangePasswordWithCaptchaActionGroup");
		$I->comment("Entering Action Group [assertSuccessMessage] AssertMessageCustomerChangeAccountInfoActionGroup");
		$I->see("You saved the account information.", "#maincontent .message-success"); // stepKey: verifyMessageAssertSuccessMessage
		$I->comment("Exiting Action Group [assertSuccessMessage] AssertMessageCustomerChangeAccountInfoActionGroup");
	}
}
