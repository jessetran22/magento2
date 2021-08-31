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
 * @Title("MC-14103: Captcha on contact us form test")
 * @Description("Test creation for send comment using the contact us form with captcha.<h3>Test files</h3>app/code/Magento/Captcha/Test/Mftf/Test/StorefrontCaptchaOnContactUsTest.xml<br>")
 * @TestCaseId("MC-14103")
 * @group captcha
 * @group mtf_migrated
 */
class StorefrontCaptchaOnContactUsTestCest
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
		$enableUserEditCaptcha = $I->magentoCLI("config:set customer/captcha/forms contact_us", 60); // stepKey: enableUserEditCaptcha
		$I->comment($enableUserEditCaptcha);
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
		$setDefaultCaptchaLength = $I->magentoCLI("config:set customer/captcha/length 4-5", 60); // stepKey: setDefaultCaptchaLength
		$I->comment($setDefaultCaptchaLength);
		$setDefaultCaptchaSymbols = $I->magentoCLI("config:set customer/captcha/symbols ABCDEFGHJKMnpqrstuvwxyz23456789", 60); // stepKey: setDefaultCaptchaSymbols
		$I->comment($setDefaultCaptchaSymbols);
		$enableCaptchaOnDefaultForms = $I->magentoCLI("config:set customer/captcha/forms user_login,user_forgotpassword", 60); // stepKey: enableCaptchaOnDefaultForms
		$I->comment($enableCaptchaOnDefaultForms);
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
	 * @Stories({"Submit Contact us form + Captcha"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StorefrontCaptchaOnContactUsTest(AcceptanceTester $I)
	{
		$I->comment("Open storefront contact us form");
		$I->comment("Entering Action Group [goToContactUsPage] StorefrontOpenContactUsPageActionGroup");
		$I->amOnPage("/contact/"); // stepKey: amOnContactUpPageGoToContactUsPage
		$I->waitForPageLoad(30); // stepKey: waitForContactUpPageLoadGoToContactUsPage
		$I->comment("Exiting Action Group [goToContactUsPage] StorefrontOpenContactUsPageActionGroup");
		$I->comment("Check Captcha items");
		$I->comment("Entering Action Group [seeCaptchaOnContactUsForm] AssertCaptchaVisibleOnContactUsFormActionGroup");
		$I->waitForElementVisible("#contact-form input[name='captcha[contact_us]']", 30); // stepKey: waitToSeeCaptchaFieldSeeCaptchaOnContactUsForm
		$I->waitForElementVisible("#contact-form img.captcha-img", 30); // stepKey: waitToSeeCaptchaImageSeeCaptchaOnContactUsForm
		$I->waitForElementVisible("#contact-form button.captcha-reload", 30); // stepKey: waitToSeeCaptchaReloadButtonSeeCaptchaOnContactUsForm
		$I->reloadPage(); // stepKey: refreshPageSeeCaptchaOnContactUsForm
		$I->waitForPageLoad(30); // stepKey: waitForPageReloadedSeeCaptchaOnContactUsForm
		$I->waitForElementVisible("#contact-form input[name='captcha[contact_us]']", 30); // stepKey: waitToSeeCaptchaFieldAfterPageReloadSeeCaptchaOnContactUsForm
		$I->waitForElementVisible("#contact-form img.captcha-img", 30); // stepKey: waitToSeeCaptchaImageAfterPageReloadSeeCaptchaOnContactUsForm
		$I->waitForElementVisible("#contact-form button.captcha-reload", 30); // stepKey: waitToSeeCaptchaReloadButtonAfterPageReloadSeeCaptchaOnContactUsForm
		$I->comment("Exiting Action Group [seeCaptchaOnContactUsForm] AssertCaptchaVisibleOnContactUsFormActionGroup");
		$I->comment("Submit Contact Us form");
		$I->comment("Entering Action Group [fillContactUsFormWithWrongCaptcha] StorefrontFillContactUsFormWithCaptchaActionGroup");
		$I->fillField("#contact-form input[name='name']", "John"); // stepKey: fillNameFillContactUsFormWithWrongCaptcha
		$I->fillField("#contact-form input[name='email']", msq("Simple_US_Customer") . "John.Doe@example.com"); // stepKey: fillEmailFillContactUsFormWithWrongCaptcha
		$I->fillField("#contact-form textarea[name='comment']", "Lorem ipsum dolor sit amet, ne enim aliquando eam, oblique deserunt no usu. Unique: " . msq("DefaultContactUsData")); // stepKey: fillCommentFillContactUsFormWithWrongCaptcha
		$I->fillField("#contact-form input[name='captcha[contact_us]']", "WrongCAPTCHA" . msq("WrongCaptcha")); // stepKey: fillCaptchaFieldFillContactUsFormWithWrongCaptcha
		$I->comment("Exiting Action Group [fillContactUsFormWithWrongCaptcha] StorefrontFillContactUsFormWithCaptchaActionGroup");
		$I->comment("Entering Action Group [submitContactUsFormWithWrongCaptcha] StorefrontSubmitContactUsFormActionGroup");
		$I->click("#contact-form button[type='submit']"); // stepKey: clickSubmitFormButtonSubmitContactUsFormWithWrongCaptcha
		$I->waitForPageLoad(30); // stepKey: clickSubmitFormButtonSubmitContactUsFormWithWrongCaptchaWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCommentSubmittedSubmitContactUsFormWithWrongCaptcha
		$I->comment("Exiting Action Group [submitContactUsFormWithWrongCaptcha] StorefrontSubmitContactUsFormActionGroup");
		$I->comment("Check Captcha items after form reload");
		$I->comment("Entering Action Group [verifyErrorMessage] AssertMessageContactUsFormActionGroup");
		$I->see("Incorrect CAPTCHA", "#maincontent .message-error"); // stepKey: verifyMessageVerifyErrorMessage
		$I->comment("Exiting Action Group [verifyErrorMessage] AssertMessageContactUsFormActionGroup");
		$I->comment("Entering Action Group [seeCaptchaOnContactUsFormAfterWrongCaptcha] AssertCaptchaVisibleOnContactUsFormActionGroup");
		$I->waitForElementVisible("#contact-form input[name='captcha[contact_us]']", 30); // stepKey: waitToSeeCaptchaFieldSeeCaptchaOnContactUsFormAfterWrongCaptcha
		$I->waitForElementVisible("#contact-form img.captcha-img", 30); // stepKey: waitToSeeCaptchaImageSeeCaptchaOnContactUsFormAfterWrongCaptcha
		$I->waitForElementVisible("#contact-form button.captcha-reload", 30); // stepKey: waitToSeeCaptchaReloadButtonSeeCaptchaOnContactUsFormAfterWrongCaptcha
		$I->reloadPage(); // stepKey: refreshPageSeeCaptchaOnContactUsFormAfterWrongCaptcha
		$I->waitForPageLoad(30); // stepKey: waitForPageReloadedSeeCaptchaOnContactUsFormAfterWrongCaptcha
		$I->waitForElementVisible("#contact-form input[name='captcha[contact_us]']", 30); // stepKey: waitToSeeCaptchaFieldAfterPageReloadSeeCaptchaOnContactUsFormAfterWrongCaptcha
		$I->waitForElementVisible("#contact-form img.captcha-img", 30); // stepKey: waitToSeeCaptchaImageAfterPageReloadSeeCaptchaOnContactUsFormAfterWrongCaptcha
		$I->waitForElementVisible("#contact-form button.captcha-reload", 30); // stepKey: waitToSeeCaptchaReloadButtonAfterPageReloadSeeCaptchaOnContactUsFormAfterWrongCaptcha
		$I->comment("Exiting Action Group [seeCaptchaOnContactUsFormAfterWrongCaptcha] AssertCaptchaVisibleOnContactUsFormActionGroup");
		$I->comment("Entering Action Group [fillContactUsFormWithCorrectCaptcha] StorefrontFillContactUsFormWithCaptchaActionGroup");
		$I->fillField("#contact-form input[name='name']", "John"); // stepKey: fillNameFillContactUsFormWithCorrectCaptcha
		$I->fillField("#contact-form input[name='email']", msq("Simple_US_Customer") . "John.Doe@example.com"); // stepKey: fillEmailFillContactUsFormWithCorrectCaptcha
		$I->fillField("#contact-form textarea[name='comment']", "Lorem ipsum dolor sit amet, ne enim aliquando eam, oblique deserunt no usu. Unique: " . msq("DefaultContactUsData")); // stepKey: fillCommentFillContactUsFormWithCorrectCaptcha
		$I->fillField("#contact-form input[name='captcha[contact_us]']", "111"); // stepKey: fillCaptchaFieldFillContactUsFormWithCorrectCaptcha
		$I->comment("Exiting Action Group [fillContactUsFormWithCorrectCaptcha] StorefrontFillContactUsFormWithCaptchaActionGroup");
		$I->comment("Entering Action Group [submitContactUsFormWithCorrectCaptcha] StorefrontSubmitContactUsFormActionGroup");
		$I->click("#contact-form button[type='submit']"); // stepKey: clickSubmitFormButtonSubmitContactUsFormWithCorrectCaptcha
		$I->waitForPageLoad(30); // stepKey: clickSubmitFormButtonSubmitContactUsFormWithCorrectCaptchaWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCommentSubmittedSubmitContactUsFormWithCorrectCaptcha
		$I->comment("Exiting Action Group [submitContactUsFormWithCorrectCaptcha] StorefrontSubmitContactUsFormActionGroup");
		$I->comment("Entering Action Group [verifySuccessMessage] AssertMessageContactUsFormActionGroup");
		$I->see("Thanks for contacting us with your comments and questions. We'll respond to you very soon.", "#maincontent .message-success"); // stepKey: verifyMessageVerifySuccessMessage
		$I->comment("Exiting Action Group [verifySuccessMessage] AssertMessageContactUsFormActionGroup");
	}
}
