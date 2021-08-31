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
 * @Title("MAGETWO-42653: Checkout via Guest Checkout with restricted countries for payment")
 * @Description("Should be able to place an order as a Guest with restricted countries for payment.<h3>Test files</h3>app/code/Magento/Checkout/Test/Mftf/Test/StorefrontGuestCheckoutTest/StorefrontGuestCheckoutTestWithRestrictedCountriesForPaymentTest.xml<br>")
 * @TestCaseId("MAGETWO-42653")
 * @group checkout
 */
class StorefrontGuestCheckoutTestWithRestrictedCountriesForPaymentTestCest
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
		$I->createEntity("createCategory", "hook", "_defaultCategory", [], []); // stepKey: createCategory
		$I->createEntity("createProduct", "hook", "ApiSimpleProduct", ["createCategory"], []); // stepKey: createProduct
		$allowSpecificValue = $I->magentoCLI("config:set payment/checkmo/allowspecific 1", 60); // stepKey: allowSpecificValue
		$I->comment($allowSpecificValue);
		$specificCountryValue = $I->magentoCLI("config:set payment/checkmo/specificcountry GB", 60); // stepKey: specificCountryValue
		$I->comment($specificCountryValue);
		$I->comment("Adding the comment to replace CliIndexerReindexActionGroup action group ('indexer:reindex' commands) for preserving Backward Compatibility");
		$I->comment("Adding the comment to replace CliCacheFlushActionGroup action group ('cache:flush' command) for preserving Backward Compatibility");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [adminLogout] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageAdminLogout
		$I->comment("Exiting Action Group [adminLogout] AdminLogoutActionGroup");
		$I->deleteEntity("createCategory", "hook"); // stepKey: deleteCategory
		$I->deleteEntity("createProduct", "hook"); // stepKey: deleteProduct
		$allowSpecificValue = $I->magentoCLI("config:set payment/checkmo/allowspecific 0", 60); // stepKey: allowSpecificValue
		$I->comment($allowSpecificValue);
		$specificCountryValue = $I->magentoCLI("config:set payment/checkmo/specificcountry ''", 60); // stepKey: specificCountryValue
		$I->comment($specificCountryValue);
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
	 * @Stories({"Checkout flow if payment solutions are not available"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StorefrontGuestCheckoutTestWithRestrictedCountriesForPaymentTest(AcceptanceTester $I)
	{
		$I->comment("Add product to cart");
		$I->amOnPage("/" . $I->retrieveEntityField('createCategory', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: onCategoryPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad1
		$I->comment("Entering Action Group [hoverProduct] StorefrontHoverProductOnCategoryPageActionGroup");
		$I->moveMouseOver(".product-item-info"); // stepKey: hoverOverProductHoverProduct
		$I->comment("Exiting Action Group [hoverProduct] StorefrontHoverProductOnCategoryPageActionGroup");
		$I->comment("Entering Action Group [addToCart] StorefrontClickAddToCartButtonActionGroup");
		$I->click("button.action.tocart.primary"); // stepKey: addToCartAddToCart
		$I->waitForPageLoad(30); // stepKey: waitAddToCartAddToCart
		$I->comment("Exiting Action Group [addToCart] StorefrontClickAddToCartButtonActionGroup");
		$I->waitForElementVisible("div.message-success", 30); // stepKey: waitForProductAdded
		$I->see("You added " . $I->retrieveEntityField('createProduct', 'name', 'test') . " to your shopping cart.", "div.message-success"); // stepKey: seeAddedToCartMessage
		$I->see("1", "span.counter-number"); // stepKey: seeCartQuantity
		$I->comment("Go to checkout page");
		$I->comment("Entering Action Group [guestGoToCheckoutFromMinicart] GoToCheckoutFromMinicartActionGroup");
		$I->waitForElementNotVisible(".counter.qty.empty", 30); // stepKey: waitUpdateQuantityGuestGoToCheckoutFromMinicart
		$I->wait(5); // stepKey: waitMinicartRenderingGuestGoToCheckoutFromMinicart
		$I->click("a.showcart"); // stepKey: clickCartGuestGoToCheckoutFromMinicart
		$I->waitForPageLoad(60); // stepKey: clickCartGuestGoToCheckoutFromMinicartWaitForPageLoad
		$I->click("#top-cart-btn-checkout"); // stepKey: goToCheckoutGuestGoToCheckoutFromMinicart
		$I->waitForPageLoad(30); // stepKey: goToCheckoutGuestGoToCheckoutFromMinicartWaitForPageLoad
		$I->comment("Exiting Action Group [guestGoToCheckoutFromMinicart] GoToCheckoutFromMinicartActionGroup");
		$I->comment("Fill US Address and verify that no payment available");
		$I->comment("Entering Action Group [guestCheckoutFillingShippingSection] GuestCheckoutWithSpecificCountryOptionForPaymentMethodActionGroup");
		$I->fillField("input[id*=customer-email]", msq("CustomerEntityOne") . "test@email.com"); // stepKey: enterEmailGuestCheckoutFillingShippingSection
		$I->fillField("input[name=firstname]", "John"); // stepKey: enterFirstNameGuestCheckoutFillingShippingSection
		$I->fillField("input[name=lastname]", "Doe"); // stepKey: enterLastNameGuestCheckoutFillingShippingSection
		$I->fillField("input[name='street[0]']", "7700 W Parmer Ln"); // stepKey: enterStreetGuestCheckoutFillingShippingSection
		$I->fillField("input[name=city]", "Austin"); // stepKey: enterCityGuestCheckoutFillingShippingSection
		$I->selectOption("select[name=region_id]", "Texas"); // stepKey: selectRegionGuestCheckoutFillingShippingSection
		$I->fillField("input[name=postcode]", "78729"); // stepKey: enterPostcodeGuestCheckoutFillingShippingSection
		$I->fillField("input[name=telephone]", "1234568910"); // stepKey: enterTelephoneGuestCheckoutFillingShippingSection
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskGuestCheckoutFillingShippingSection
		$I->click("//*[@id='checkout-shipping-method-load']//input[@class='radio']"); // stepKey: selectFirstShippingMethodGuestCheckoutFillingShippingSection
		$I->waitForElement("button.button.action.continue.primary", 30); // stepKey: waitForNextButtonGuestCheckoutFillingShippingSection
		$I->waitForPageLoad(30); // stepKey: waitForNextButtonGuestCheckoutFillingShippingSectionWaitForPageLoad
		$I->click("button.button.action.continue.primary"); // stepKey: clickNextGuestCheckoutFillingShippingSection
		$I->waitForPageLoad(30); // stepKey: clickNextGuestCheckoutFillingShippingSectionWaitForPageLoad
		$I->seeInCurrentUrl("/checkout/#payment"); // stepKey: assertCheckoutPaymentUrlGuestCheckoutFillingShippingSection
		$I->waitForElementVisible(".no-quotes-block", 30); // stepKey: waitMessageGuestCheckoutFillingShippingSection
		$I->dontSee("//*[@id='checkout-payment-method-load']//*[contains(@class, 'payment-group')]//label[normalize-space(.)='Check / Money order']"); // stepKey: paymentMethodDoesNotAvailableGuestCheckoutFillingShippingSection
		$I->comment("Exiting Action Group [guestCheckoutFillingShippingSection] GuestCheckoutWithSpecificCountryOptionForPaymentMethodActionGroup");
		$I->comment("Fill UK Address and verify that payment available and checkout successful");
		$I->click(".opc-progress-bar-item:nth-of-type(1)"); // stepKey: goToShipping
		$I->waitForPageLoad(30); // stepKey: goToShippingWaitForPageLoad
		$I->comment("Entering Action Group [guestCheckoutFillingShippingSectionUK] GuestCheckoutFillingShippingSectionWithoutRegionActionGroup");
		$I->fillField("input[id*=customer-email]", msq("CustomerEntityOne") . "test@email.com"); // stepKey: enterEmailGuestCheckoutFillingShippingSectionUK
		$I->fillField("input[name=firstname]", "John"); // stepKey: enterFirstNameGuestCheckoutFillingShippingSectionUK
		$I->fillField("input[name=lastname]", "Doe"); // stepKey: enterLastNameGuestCheckoutFillingShippingSectionUK
		$I->fillField("input[name='street[0]']", "172, Westminster Bridge Rd"); // stepKey: enterStreetGuestCheckoutFillingShippingSectionUK
		$I->fillField("input[name=city]", "London"); // stepKey: enterCityGuestCheckoutFillingShippingSectionUK
		$I->fillField("input[name=postcode]", "SE1 7RW"); // stepKey: enterPostcodeGuestCheckoutFillingShippingSectionUK
		$I->selectOption("select[name=country_id]", "GB"); // stepKey: enterCountryGuestCheckoutFillingShippingSectionUK
		$I->fillField("input[name=telephone]", "444-44-444-44"); // stepKey: enterTelephoneGuestCheckoutFillingShippingSectionUK
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskGuestCheckoutFillingShippingSectionUK
		$I->click("//*[@id='checkout-shipping-method-load']//input[@class='radio']"); // stepKey: selectFirstShippingMethodGuestCheckoutFillingShippingSectionUK
		$I->waitForElement("button.button.action.continue.primary", 30); // stepKey: waitForNextButtonGuestCheckoutFillingShippingSectionUK
		$I->waitForPageLoad(30); // stepKey: waitForNextButtonGuestCheckoutFillingShippingSectionUKWaitForPageLoad
		$I->click("button.button.action.continue.primary"); // stepKey: clickNextGuestCheckoutFillingShippingSectionUK
		$I->waitForPageLoad(30); // stepKey: clickNextGuestCheckoutFillingShippingSectionUKWaitForPageLoad
		$I->waitForElement("//*[@id='checkout-payment-method-load']//div[@data-role='title']", 30); // stepKey: waitForPaymentSectionLoadedGuestCheckoutFillingShippingSectionUK
		$I->seeInCurrentUrl("/checkout/#payment"); // stepKey: assertCheckoutPaymentUrlGuestCheckoutFillingShippingSectionUK
		$I->comment("Exiting Action Group [guestCheckoutFillingShippingSectionUK] GuestCheckoutFillingShippingSectionWithoutRegionActionGroup");
		$I->comment("Entering Action Group [guestSelectCheckMoneyOrderPayment] CheckoutSelectCheckMoneyOrderPaymentActionGroup");
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskGuestSelectCheckMoneyOrderPayment
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadGuestSelectCheckMoneyOrderPayment
		$I->conditionalClick("//div[@id='checkout-payment-method-load']//div[@class='payment-method']//label//span[contains(., 'Check / Money order')]/../..//input", "//div[@id='checkout-payment-method-load']//div[@class='payment-method']//label//span[contains(., 'Check / Money order')]/../..//input", true); // stepKey: selectCheckmoPaymentMethodGuestSelectCheckMoneyOrderPayment
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskAfterPaymentMethodSelectionGuestSelectCheckMoneyOrderPayment
		$I->comment("Exiting Action Group [guestSelectCheckMoneyOrderPayment] CheckoutSelectCheckMoneyOrderPaymentActionGroup");
		$I->comment("Entering Action Group [guestPlaceorder] CheckoutPlaceOrderActionGroup");
		$I->waitForElementVisible(".payment-method._active button.action.primary.checkout", 30); // stepKey: waitForPlaceOrderButtonGuestPlaceorder
		$I->waitForPageLoad(30); // stepKey: waitForPlaceOrderButtonGuestPlaceorderWaitForPageLoad
		$I->click(".payment-method._active button.action.primary.checkout"); // stepKey: clickPlaceOrderGuestPlaceorder
		$I->waitForPageLoad(30); // stepKey: clickPlaceOrderGuestPlaceorderWaitForPageLoad
		$I->see("Your order # is:", "div.checkout-success"); // stepKey: seeOrderNumberGuestPlaceorder
		$I->see("We'll email you an order confirmation with details and tracking info.", "div.checkout-success"); // stepKey: seeEmailYouGuestPlaceorder
		$I->comment("Exiting Action Group [guestPlaceorder] CheckoutPlaceOrderActionGroup");
	}
}
