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
 * @Title("MAGETWO-96691: Captcha is displaying on login form with disabled guest checkout")
 * @Description("Captcha is displaying on login form with disabled guest checkout<h3>Test files</h3>app/code/Magento/Captcha/Test/Mftf/Test/CaptchaFormsDisplayingTest/CaptchaWithDisabledGuestCheckoutTest.xml<br>")
 * @TestCaseId("MAGETWO-96691")
 * @group captcha
 */
class CaptchaWithDisabledGuestCheckoutTestCest
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
		$disableGuestCheckout = $I->magentoCLI("config:set checkout/options/guest_checkout 0", 60); // stepKey: disableGuestCheckout
		$I->comment($disableGuestCheckout);
		$decreaseLoginAttempt = $I->magentoCLI("config:set customer/captcha/failed_attempts_login 1", 60); // stepKey: decreaseLoginAttempt
		$I->comment($decreaseLoginAttempt);
		$I->createEntity("createCategory", "hook", "ApiCategory", [], []); // stepKey: createCategory
		$I->createEntity("createSimpleProduct", "hook", "ApiSimpleProduct", ["createCategory"], []); // stepKey: createSimpleProduct
		$runCronIndex = $I->magentoCron("index", 90); // stepKey: runCronIndex
		$I->comment($runCronIndex);
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$enableGuestCheckout = $I->magentoCLI("config:set checkout/options/guest_checkout 1", 60); // stepKey: enableGuestCheckout
		$I->comment($enableGuestCheckout);
		$increaseLoginAttempt = $I->magentoCLI("config:set customer/captcha/failed_attempts_login 3", 60); // stepKey: increaseLoginAttempt
		$I->comment($increaseLoginAttempt);
		$I->deleteEntity("createCategory", "hook"); // stepKey: deleteCategory
		$I->deleteEntity("createSimpleProduct", "hook"); // stepKey: deleteSimpleProduct1
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
	 * @Stories({"MC-5602 - CAPTCHA doesn't appear in login popup after refreshing page."})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function CaptchaWithDisabledGuestCheckoutTest(AcceptanceTester $I)
	{
		$I->amOnPage("/" . $I->retrieveEntityField('createSimpleProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: openProductPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad
		$I->comment("Entering Action Group [addToCartFromStorefrontProductPage] StorefrontClickAddToCartOnProductPageActionGroup");
		$I->click("#product-addtocart-button"); // stepKey: addToCartAddToCartFromStorefrontProductPage
		$I->waitForPageLoad(60); // stepKey: addToCartAddToCartFromStorefrontProductPageWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForAddToCartAddToCartFromStorefrontProductPage
		$I->waitForElementVisible("div.message-success.success.message", 30); // stepKey: waitForSuccessMessageAddToCartFromStorefrontProductPage
		$I->comment("Exiting Action Group [addToCartFromStorefrontProductPage] StorefrontClickAddToCartOnProductPageActionGroup");
		$I->waitForText("You added " . $I->retrieveEntityField('createSimpleProduct', 'name', 'test') . " to your shopping cart.", 30); // stepKey: waitForText
		$I->comment("Entering Action Group [clickCart] StorefrontClickOnMiniCartActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollToTheTopOfThePageClickCart
		$I->waitForElementVisible("a.showcart", 30); // stepKey: waitForElementToBeVisibleClickCart
		$I->waitForPageLoad(60); // stepKey: waitForElementToBeVisibleClickCartWaitForPageLoad
		$I->click("a.showcart"); // stepKey: clickOnMiniCartClickCart
		$I->waitForPageLoad(60); // stepKey: clickOnMiniCartClickCartWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadClickCart
		$I->comment("Exiting Action Group [clickCart] StorefrontClickOnMiniCartActionGroup");
		$I->click("#top-cart-btn-checkout"); // stepKey: goToCheckout
		$I->waitForPageLoad(30); // stepKey: goToCheckoutWaitForPageLoad
		$I->waitForElementVisible("#customer-email", 30); // stepKey: waitEmailFieldVisible
		$I->fillField("#customer-email", msq("Simple_US_Customer") . "John.Doe@example.com"); // stepKey: fillCustomerEmail
		$I->fillField("#pass", "incorrectPassword"); // stepKey: fillIncorrectCustomerPassword
		$I->click("#send2"); // stepKey: clickSignIn
		$I->waitForPageLoad(30); // stepKey: clickSignInWaitForPageLoad
		$I->waitForElementVisible("[data-ui-id='checkout-cart-validationmessages-message-error']", 30); // stepKey: seeErrorMessage
		$I->waitForElementVisible("#captcha_user_login", 30); // stepKey: seeCaptchaField
		$I->waitForElementVisible(".captcha-img", 30); // stepKey: seeCaptchaImage
		$I->waitForElementVisible(".captcha-reload", 30); // stepKey: seeCaptchaReloadButton
		$I->comment("Entering Action Group [refreshPage] ReloadPageActionGroup");
		$I->reloadPage(); // stepKey: reloadPageRefreshPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadRefreshPage
		$I->comment("Exiting Action Group [refreshPage] ReloadPageActionGroup");
		$I->comment("Replacing reload action and preserve Backward Compatibility");
		$I->comment("Entering Action Group [clickCart2] StorefrontClickOnMiniCartActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollToTheTopOfThePageClickCart2
		$I->waitForElementVisible("a.showcart", 30); // stepKey: waitForElementToBeVisibleClickCart2
		$I->waitForPageLoad(60); // stepKey: waitForElementToBeVisibleClickCart2WaitForPageLoad
		$I->click("a.showcart"); // stepKey: clickOnMiniCartClickCart2
		$I->waitForPageLoad(60); // stepKey: clickOnMiniCartClickCart2WaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadClickCart2
		$I->comment("Exiting Action Group [clickCart2] StorefrontClickOnMiniCartActionGroup");
		$I->click("#top-cart-btn-checkout"); // stepKey: goToCheckout2
		$I->waitForPageLoad(30); // stepKey: goToCheckout2WaitForPageLoad
		$I->waitForElementVisible("#customer-email", 30); // stepKey: waitEmailFieldVisible2
		$I->waitForElementVisible("#captcha_user_login", 30); // stepKey: seeCaptchaField2
		$I->waitForElementVisible(".captcha-img", 30); // stepKey: seeCaptchaImage2
		$I->waitForElementVisible(".captcha-reload", 30); // stepKey: seeCaptchaReloadButton2
	}
}
