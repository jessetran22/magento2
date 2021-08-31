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
 * @Title("MC-14695: Guest e-mail address validation on Checkout process")
 * @Description("Guest should not be able to place an order when invalid e-mail address provided<h3>Test files</h3>app/code/Magento/Checkout/Test/Mftf/Test/StorefrontValidateEmailOnCheckoutTest.xml<br>")
 * @TestCaseId("MC-14695")
 * @group checkout
 * @group shoppingCart
 * @group mtf_migrated
 */
class StorefrontValidateEmailOnCheckoutTestCest
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
		$I->createEntity("simpleProduct", "hook", "SimpleTwo", [], []); // stepKey: simpleProduct
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->deleteEntity("simpleProduct", "hook"); // stepKey: deleteProduct
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
	 * @Features({"Checkout"})
	 * @Stories({"Guest Checkout e-mail validation", "Guest Checkout"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StorefrontValidateEmailOnCheckoutTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [openProductStorefront] StorefrontOpenProductPageActionGroup");
		$I->amOnPage("/" . $I->retrieveEntityField('simpleProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: openProductPageOpenProductStorefront
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoadedOpenProductStorefront
		$I->comment("Exiting Action Group [openProductStorefront] StorefrontOpenProductPageActionGroup");
		$I->comment("Entering Action Group [addToCartFromStorefrontProductPage] StorefrontClickAddToCartOnProductPageActionGroup");
		$I->click("#product-addtocart-button"); // stepKey: addToCartAddToCartFromStorefrontProductPage
		$I->waitForPageLoad(60); // stepKey: addToCartAddToCartFromStorefrontProductPageWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForAddToCartAddToCartFromStorefrontProductPage
		$I->waitForElementVisible("div.message-success.success.message", 30); // stepKey: waitForSuccessMessageAddToCartFromStorefrontProductPage
		$I->comment("Exiting Action Group [addToCartFromStorefrontProductPage] StorefrontClickAddToCartOnProductPageActionGroup");
		$I->comment("Entering Action Group [openCheckoutPage] StorefrontOpenCheckoutPageActionGroup");
		$I->amOnPage("/checkout"); // stepKey: openCheckoutPageOpenCheckoutPage
		$I->waitForPageLoad(30); // stepKey: waitForCheckoutPageLoadedOpenCheckoutPage
		$I->comment("Exiting Action Group [openCheckoutPage] StorefrontOpenCheckoutPageActionGroup");
		$I->comment("Entering Action Group [assertEmailTooltipContent] AssertStorefrontEmailTooltipContentOnCheckoutActionGroup");
		$I->waitForElementVisible("//form[@data-role='email-with-possible-login']//div[input[@name='username']]//*[contains(@class, 'action-help')]", 30); // stepKey: waitForTooltipButtonVisibleAssertEmailTooltipContent
		$I->click("//form[@data-role='email-with-possible-login']//div[input[@name='username']]//*[contains(@class, 'action-help')]"); // stepKey: clickEmailTooltipButtonAssertEmailTooltipContent
		$I->see("We'll send your order confirmation here.", "//form[@data-role='email-with-possible-login']//div[input[@name='username']]//*[contains(@class, 'field-tooltip-content')]"); // stepKey: seeEmailTooltipContentAssertEmailTooltipContent
		$I->comment("Exiting Action Group [assertEmailTooltipContent] AssertStorefrontEmailTooltipContentOnCheckoutActionGroup");
		$I->comment("Entering Action Group [assertEmailNoteMessage] AssertStorefrontEmailNoteMessageOnCheckoutActionGroup");
		$I->waitForElementVisible("//form[@data-role='email-with-possible-login']//div[input[@name='username']]//*[contains(@class, 'note')]", 30); // stepKey: waitForFormValidationAssertEmailNoteMessage
		$I->see("You can create an account after checkout.", "//form[@data-role='email-with-possible-login']//div[input[@name='username']]//*[contains(@class, 'note')]"); // stepKey: seeTheNoteMessageIsDisplayedAssertEmailNoteMessage
		$I->comment("Exiting Action Group [assertEmailNoteMessage] AssertStorefrontEmailNoteMessageOnCheckoutActionGroup");
		$I->comment("Entering Action Group [fillIncorrectEmailFirstAttempt] StorefrontFillEmailFieldOnCheckoutActionGroup");
		$I->fillField("form[data-role='email-with-possible-login'] input[name='username']", "John"); // stepKey: fillCustomerEmailFieldFillIncorrectEmailFirstAttempt
		$I->doubleClick("//form[@data-role='email-with-possible-login']//div[input[@name='username']]//*[contains(@class, 'action-help')]"); // stepKey: clickToMoveFocusFromEmailInputFillIncorrectEmailFirstAttempt
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadFillIncorrectEmailFirstAttempt
		$I->comment("Exiting Action Group [fillIncorrectEmailFirstAttempt] StorefrontFillEmailFieldOnCheckoutActionGroup");
		$I->comment("Entering Action Group [verifyValidationErrorMessageFirstAttempt] AssertStorefrontEmailValidationMessageOnCheckoutActionGroup");
		$I->waitForElementVisible("//form[@data-role='email-with-possible-login']//div[input[@name='username']]//*[@id='customer-email-error']", 30); // stepKey: waitForFormValidationVerifyValidationErrorMessageFirstAttempt
		$I->see("Please enter a valid email address (Ex: johndoe@domain.com).", "//form[@data-role='email-with-possible-login']//div[input[@name='username']]//*[@id='customer-email-error']"); // stepKey: seeTheErrorMessageIsDisplayedVerifyValidationErrorMessageFirstAttempt
		$I->comment("Exiting Action Group [verifyValidationErrorMessageFirstAttempt] AssertStorefrontEmailValidationMessageOnCheckoutActionGroup");
		$I->comment("Entering Action Group [fillIncorrectEmailSecondAttempt] StorefrontFillEmailFieldOnCheckoutActionGroup");
		$I->fillField("form[data-role='email-with-possible-login'] input[name='username']", "johndoe#example.com"); // stepKey: fillCustomerEmailFieldFillIncorrectEmailSecondAttempt
		$I->doubleClick("//form[@data-role='email-with-possible-login']//div[input[@name='username']]//*[contains(@class, 'action-help')]"); // stepKey: clickToMoveFocusFromEmailInputFillIncorrectEmailSecondAttempt
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadFillIncorrectEmailSecondAttempt
		$I->comment("Exiting Action Group [fillIncorrectEmailSecondAttempt] StorefrontFillEmailFieldOnCheckoutActionGroup");
		$I->comment("Entering Action Group [verifyValidationErrorMessageSecondAttempt] AssertStorefrontEmailValidationMessageOnCheckoutActionGroup");
		$I->waitForElementVisible("//form[@data-role='email-with-possible-login']//div[input[@name='username']]//*[@id='customer-email-error']", 30); // stepKey: waitForFormValidationVerifyValidationErrorMessageSecondAttempt
		$I->see("Please enter a valid email address (Ex: johndoe@domain.com).", "//form[@data-role='email-with-possible-login']//div[input[@name='username']]//*[@id='customer-email-error']"); // stepKey: seeTheErrorMessageIsDisplayedVerifyValidationErrorMessageSecondAttempt
		$I->comment("Exiting Action Group [verifyValidationErrorMessageSecondAttempt] AssertStorefrontEmailValidationMessageOnCheckoutActionGroup");
		$I->comment("Entering Action Group [fillIncorrectEmailThirdAttempt] StorefrontFillEmailFieldOnCheckoutActionGroup");
		$I->fillField("form[data-role='email-with-possible-login'] input[name='username']", "johndoe@example.c"); // stepKey: fillCustomerEmailFieldFillIncorrectEmailThirdAttempt
		$I->doubleClick("//form[@data-role='email-with-possible-login']//div[input[@name='username']]//*[contains(@class, 'action-help')]"); // stepKey: clickToMoveFocusFromEmailInputFillIncorrectEmailThirdAttempt
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadFillIncorrectEmailThirdAttempt
		$I->comment("Exiting Action Group [fillIncorrectEmailThirdAttempt] StorefrontFillEmailFieldOnCheckoutActionGroup");
		$I->comment("Entering Action Group [verifyValidationErrorMessageThirdAttempt] AssertStorefrontEmailValidationMessageOnCheckoutActionGroup");
		$I->waitForElementVisible("//form[@data-role='email-with-possible-login']//div[input[@name='username']]//*[@id='customer-email-error']", 30); // stepKey: waitForFormValidationVerifyValidationErrorMessageThirdAttempt
		$I->see("Please enter a valid email address (Ex: johndoe@domain.com).", "//form[@data-role='email-with-possible-login']//div[input[@name='username']]//*[@id='customer-email-error']"); // stepKey: seeTheErrorMessageIsDisplayedVerifyValidationErrorMessageThirdAttempt
		$I->comment("Exiting Action Group [verifyValidationErrorMessageThirdAttempt] AssertStorefrontEmailValidationMessageOnCheckoutActionGroup");
	}
}
