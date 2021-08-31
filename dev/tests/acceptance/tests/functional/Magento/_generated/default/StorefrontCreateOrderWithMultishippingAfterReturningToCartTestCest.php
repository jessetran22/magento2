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
 * @Title("MC-39583: Checkout with multiple addresses after returning on cart page during checkout.")
 * @Description("Verify customer able to checkout with multiple addresses after returning to cart page and continue checkout with browser 'back' button.<h3>Test files</h3>app/code/Magento/Multishipping/Test/Mftf/Test/StorefrontCreateOrderWithMultishippingAfterReturningToCartTest.xml<br>")
 * @TestCaseId("MC-39583")
 * @group multishipping
 */
class StorefrontCreateOrderWithMultishippingAfterReturningToCartTestCest
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
		$I->comment("Create test data.");
		$I->createEntity("product", "hook", "SimpleProduct2", [], []); // stepKey: product
		$I->createEntity("customer", "hook", "Simple_US_Customer_Two_Addresses", [], []); // stepKey: customer
		$I->comment("Set up configuration.");
		$I->comment("Entering Action Group [enableFreeShipping] CliEnableFreeShippingMethodActionGroup");
		$enableFreeShippingMethodEnableFreeShipping = $I->magentoCLI("config:set carriers/freeshipping/active 1", 60); // stepKey: enableFreeShippingMethodEnableFreeShipping
		$I->comment($enableFreeShippingMethodEnableFreeShipping);
		$I->comment("Exiting Action Group [enableFreeShipping] CliEnableFreeShippingMethodActionGroup");
		$I->comment("Entering Action Group [enableFlatRateShipping] CliEnableFlatRateShippingMethodActionGroup");
		$enableFlatRateShippingMethodEnableFlatRateShipping = $I->magentoCLI("config:set carriers/flatrate/active 1", 60); // stepKey: enableFlatRateShippingMethodEnableFlatRateShipping
		$I->comment($enableFlatRateShippingMethodEnableFlatRateShipping);
		$I->comment("Exiting Action Group [enableFlatRateShipping] CliEnableFlatRateShippingMethodActionGroup");
		$I->comment("Entering Action Group [enableCheckMoneyOrderPaymentMethod] CliEnableCheckMoneyOrderPaymentMethodActionGroup");
		$enableCheckMoneyOrderPaymentMethodEnableCheckMoneyOrderPaymentMethod = $I->magentoCLI("config:set payment/checkmo/active 1", 60); // stepKey: enableCheckMoneyOrderPaymentMethodEnableCheckMoneyOrderPaymentMethod
		$I->comment($enableCheckMoneyOrderPaymentMethodEnableCheckMoneyOrderPaymentMethod);
		$I->comment("Exiting Action Group [enableCheckMoneyOrderPaymentMethod] CliEnableCheckMoneyOrderPaymentMethodActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Clean up test data, revert configuration.");
		$I->deleteEntity("product", "hook"); // stepKey: deleteProduct
		$I->comment("Entering Action Group [customerLogoutStorefront] StorefrontCustomerLogoutActionGroup");
		$I->amOnPage("customer/account/logout/"); // stepKey: storefrontSignOutCustomerLogoutStorefront
		$I->waitForPageLoad(30); // stepKey: waitForSignOutCustomerLogoutStorefront
		$I->comment("Exiting Action Group [customerLogoutStorefront] StorefrontCustomerLogoutActionGroup");
		$I->deleteEntity("customer", "hook"); // stepKey: deleteCustomer
		$I->comment("Entering Action Group [disableFreeShipping] CliDisableFreeShippingMethodActionGroup");
		$disableFreeShippingMethodDisableFreeShipping = $I->magentoCLI("config:set carriers/freeshipping/active 0", 60); // stepKey: disableFreeShippingMethodDisableFreeShipping
		$I->comment($disableFreeShippingMethodDisableFreeShipping);
		$I->comment("Exiting Action Group [disableFreeShipping] CliDisableFreeShippingMethodActionGroup");
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
	 * @Features({"Multishipping"})
	 * @Stories({"Checkout with multiple addresses."})
	 * @Severity(level = SeverityLevel::MINOR)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StorefrontCreateOrderWithMultishippingAfterReturningToCartTest(AcceptanceTester $I)
	{
		$I->comment("Add product to cart and proceed to multishipping checkout.");
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
		$I->comment("Entering Action Group [navigateToProductPage] StorefrontOpenProductPageActionGroup");
		$I->amOnPage("/" . $I->retrieveEntityField('product', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: openProductPageNavigateToProductPage
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoadedNavigateToProductPage
		$I->comment("Exiting Action Group [navigateToProductPage] StorefrontOpenProductPageActionGroup");
		$I->comment("Entering Action Group [addProductToCart] AddProductWithQtyToCartFromStorefrontProductPageActionGroup");
		$I->fillField("#qty", "2"); // stepKey: fillProductQuantityAddProductToCart
		$I->click("#product-addtocart-button"); // stepKey: addToCartAddProductToCart
		$I->waitForPageLoad(60); // stepKey: addToCartAddProductToCartWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForAddToCartAddProductToCart
		$I->waitForElementNotVisible("//button/span[text()='Adding...']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddingAddProductToCart
		$I->waitForElementNotVisible("//button/span[text()='Added']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddedAddProductToCart
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAddProductToCart
		$I->waitForElementVisible("div.message-success.success.message", 30); // stepKey: waitForSuccessMessageAddProductToCart
		$I->see("You added " . $I->retrieveEntityField('product', 'name', 'test') . " to your shopping cart.", "div.message-success.success.message"); // stepKey: seeAddToCartSuccessMessageAddProductToCart
		$I->comment("Exiting Action Group [addProductToCart] AddProductWithQtyToCartFromStorefrontProductPageActionGroup");
		$I->comment("Entering Action Group [openCart] StorefrontOpenCartFromMinicartActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollToTopOfThePageOpenCart
		$I->waitForElement("a.showcart", 30); // stepKey: waitForShowMinicartOpenCart
		$I->waitForPageLoad(60); // stepKey: waitForShowMinicartOpenCartWaitForPageLoad
		$I->waitForElement(".action.viewcart", 30); // stepKey: waitForCartLinkOpenCart
		$I->waitForPageLoad(30); // stepKey: waitForCartLinkOpenCartWaitForPageLoad
		$I->click("a.showcart"); // stepKey: clickShowMinicartOpenCart
		$I->waitForPageLoad(60); // stepKey: clickShowMinicartOpenCartWaitForPageLoad
		$I->click(".action.viewcart"); // stepKey: clickCartOpenCart
		$I->waitForPageLoad(30); // stepKey: clickCartOpenCartWaitForPageLoad
		$I->comment("Exiting Action Group [openCart] StorefrontOpenCartFromMinicartActionGroup");
		$I->comment("Entering Action Group [checkoutWithMultipleAddresses] CheckingWithMultipleAddressesActionGroup");
		$I->click("//span[text()='Check Out with Multiple Addresses']"); // stepKey: clickOnCheckoutWithMultipleAddressesCheckoutWithMultipleAddresses
		$I->waitForPageLoad(30); // stepKey: waitForMultipleAddressPageLoadCheckoutWithMultipleAddresses
		$firstShippingAddressValueCheckoutWithMultipleAddresses = $I->grabTextFrom("#multiship-addresses-table tbody tr:nth-of-type(1) .col.address select option:nth-of-type(1)"); // stepKey: firstShippingAddressValueCheckoutWithMultipleAddresses
		$I->selectOption("//tr[position()=1]//td[@data-th='Send To']//select", $firstShippingAddressValueCheckoutWithMultipleAddresses); // stepKey: selectFirstShippingMethodCheckoutWithMultipleAddresses
		$I->waitForPageLoad(30); // stepKey: waitForSecondShippingAddressesCheckoutWithMultipleAddresses
		$secondShippingAddressValueCheckoutWithMultipleAddresses = $I->grabTextFrom("#multiship-addresses-table tbody tr:nth-of-type(2) .col.address select option:nth-of-type(2)"); // stepKey: secondShippingAddressValueCheckoutWithMultipleAddresses
		$I->selectOption("//tr[position()=2]//td[@data-th='Send To']//select", $secondShippingAddressValueCheckoutWithMultipleAddresses); // stepKey: selectSecondShippingMethodCheckoutWithMultipleAddresses
		$I->click("//button[@class='action update']"); // stepKey: clickOnUpdateAddressCheckoutWithMultipleAddresses
		$I->waitForPageLoad(30); // stepKey: waitForShippingInformationCheckoutWithMultipleAddresses
		$I->click("//span[text()='Go to Shipping Information']"); // stepKey: goToShippingInformationCheckoutWithMultipleAddresses
		$I->waitForPageLoad(30); // stepKey: waitForShippingPageLoadCheckoutWithMultipleAddresses
		$I->comment("Exiting Action Group [checkoutWithMultipleAddresses] CheckingWithMultipleAddressesActionGroup");
		$I->comment("Entering Action Group [checkoutWithMultipleShipping] SelectMultiShippingInfoActionGroup");
		$I->selectOption("//div[@class='block block-shipping'][position()=1]//dd[position()=1]//input[@class='radio']", "Fixed"); // stepKey: selectShippingMethod1CheckoutWithMultipleShipping
		$I->waitForPageLoad(5); // stepKey: selectShippingMethod1CheckoutWithMultipleShippingWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForSecondShippingMethodCheckoutWithMultipleShipping
		$I->selectOption("//div[@class='block block-shipping'][position()=2]//dd[position()=2]//input[@class='radio']", "Free"); // stepKey: selectShippingMethod2CheckoutWithMultipleShipping
		$I->waitForPageLoad(5); // stepKey: selectShippingMethod2CheckoutWithMultipleShippingWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForRadioOptionsCheckoutWithMultipleShipping
		$I->click(".action.primary.continue"); // stepKey: goToBillingInformationCheckoutWithMultipleShipping
		$I->comment("Exiting Action Group [checkoutWithMultipleShipping] SelectMultiShippingInfoActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForShippingInfoPage
		$I->comment("Open cart page before place order.");
		$I->comment("Entering Action Group [navigateToCartPage] StorefrontCartPageOpenActionGroup");
		$I->amOnPage("/checkout/cart"); // stepKey: openCartPageNavigateToCartPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadedNavigateToCartPage
		$I->comment("Exiting Action Group [navigateToCartPage] StorefrontCartPageOpenActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForCartPageLoad
		$I->comment("Go back to continue checkout with multiple addresses again.");
		$I->moveBack(); // stepKey: navigateBackToMultishippingCheckout
		$I->comment("Entering Action Group [selectAddresses] StorefrontSelectMultipleAddressesOnCheckoutActionGroup");
		$I->waitForElementVisible("#multiship-addresses-table tbody tr:nth-of-type(1) .col.address select option:nth-of-type(1)", 30); // stepKey: waitForMultishippingPageSelectAddresses
		$firstShippingAddressValueSelectAddresses = $I->grabTextFrom("#multiship-addresses-table tbody tr:nth-of-type(1) .col.address select option:nth-of-type(1)"); // stepKey: firstShippingAddressValueSelectAddresses
		$I->selectOption("//tr[position()=1]//td[@data-th='Send To']//select", $firstShippingAddressValueSelectAddresses); // stepKey: selectFirstShippingMethodSelectAddresses
		$I->waitForPageLoad(30); // stepKey: waitForSecondShippingAddressesSelectAddresses
		$secondShippingAddressValueSelectAddresses = $I->grabTextFrom("#multiship-addresses-table tbody tr:nth-of-type(2) .col.address select option:nth-of-type(2)"); // stepKey: secondShippingAddressValueSelectAddresses
		$I->selectOption("//tr[position()=2]//td[@data-th='Send To']//select", $secondShippingAddressValueSelectAddresses); // stepKey: selectSecondShippingMethodSelectAddresses
		$I->click("//button[@class='action update']"); // stepKey: clickOnUpdateAddressSelectAddresses
		$I->waitForPageLoad(30); // stepKey: waitForShippingInformationSelectAddresses
		$I->comment("Exiting Action Group [selectAddresses] StorefrontSelectMultipleAddressesOnCheckoutActionGroup");
		$I->comment("Entering Action Group [navigateToShippingInformationPage] StorefrontNavigateToShippingInformationPageActionGroup");
		$I->waitForElementVisible("//span[text()='Go to Shipping Information']", 30); // stepKey: waitForButtonNavigateToShippingInformationPage
		$I->click("//span[text()='Go to Shipping Information']"); // stepKey: goToShippingInformationNavigateToShippingInformationPage
		$I->waitForPageLoad(30); // stepKey: waitForShippingInfoPageNavigateToShippingInformationPage
		$I->comment("Exiting Action Group [navigateToShippingInformationPage] StorefrontNavigateToShippingInformationPageActionGroup");
		$I->comment("Entering Action Group [checkoutWithMultipleShippingAgain] SelectMultiShippingInfoActionGroup");
		$I->selectOption("//div[@class='block block-shipping'][position()=1]//dd[position()=1]//input[@class='radio']", "Fixed"); // stepKey: selectShippingMethod1CheckoutWithMultipleShippingAgain
		$I->waitForPageLoad(5); // stepKey: selectShippingMethod1CheckoutWithMultipleShippingAgainWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForSecondShippingMethodCheckoutWithMultipleShippingAgain
		$I->selectOption("//div[@class='block block-shipping'][position()=2]//dd[position()=2]//input[@class='radio']", "Free"); // stepKey: selectShippingMethod2CheckoutWithMultipleShippingAgain
		$I->waitForPageLoad(5); // stepKey: selectShippingMethod2CheckoutWithMultipleShippingAgainWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForRadioOptionsCheckoutWithMultipleShippingAgain
		$I->click(".action.primary.continue"); // stepKey: goToBillingInformationCheckoutWithMultipleShippingAgain
		$I->comment("Exiting Action Group [checkoutWithMultipleShippingAgain] SelectMultiShippingInfoActionGroup");
		$I->comment("Entering Action Group [selectCheckMoneyPaymentAgain] CheckoutSelectCheckMoneyOrderPaymentActionGroup");
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskSelectCheckMoneyPaymentAgain
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadSelectCheckMoneyPaymentAgain
		$I->conditionalClick("//div[@id='checkout-payment-method-load']//div[@class='payment-method']//label//span[contains(., 'Check / Money order')]/../..//input", "//div[@id='checkout-payment-method-load']//div[@class='payment-method']//label//span[contains(., 'Check / Money order')]/../..//input", true); // stepKey: selectCheckmoPaymentMethodSelectCheckMoneyPaymentAgain
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskAfterPaymentMethodSelectionSelectCheckMoneyPaymentAgain
		$I->comment("Exiting Action Group [selectCheckMoneyPaymentAgain] CheckoutSelectCheckMoneyOrderPaymentActionGroup");
		$I->comment("Entering Action Group [checkoutWithPaymentMethodAgain] SelectBillingInfoActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForBillingInfoPageLoadCheckoutWithPaymentMethodAgain
		$I->click("#payment-continue"); // stepKey: goToReviewOrderCheckoutWithPaymentMethodAgain
		$I->waitForPageLoad(30); // stepKey: goToReviewOrderCheckoutWithPaymentMethodAgainWaitForPageLoad
		$I->comment("Exiting Action Group [checkoutWithPaymentMethodAgain] SelectBillingInfoActionGroup");
		$I->comment("Entering Action Group [reviewOrderForMultiShipment] ReviewOrderForMultiShipmentActionGroup");
		$I->comment("Check First Shipping Method Price");
		$firstShippingMethodBasePriceReviewOrderForMultiShipment = $I->grabTextFrom("//div[@class='block-content'][position()=1]//div[@class='box box-shipping-method'][position()=1]//span[@class='price']"); // stepKey: firstShippingMethodBasePriceReviewOrderForMultiShipment
		$firstShippingMethodSubtotalPriceReviewOrderForMultiShipment = $I->grabTextFrom("//div[@class='block-content'][position()=1]//td[@class='amount'][contains(@data-th,'Shipping & Handling')]//span[@class='price']"); // stepKey: firstShippingMethodSubtotalPriceReviewOrderForMultiShipment
		$I->assertEquals("$firstShippingMethodSubtotalPriceReviewOrderForMultiShipment", "$firstShippingMethodBasePriceReviewOrderForMultiShipment"); // stepKey: assertShippingMethodPriceReviewOrderForMultiShipment
		$I->comment("Check Second Shipping Method Price");
		$secondShippingMethodBasePriceReviewOrderForMultiShipment = $I->grabTextFrom("//div[@class='block-content'][position()=2]//div[@class='box box-shipping-method'][position()=1]//span[@class='price']"); // stepKey: secondShippingMethodBasePriceReviewOrderForMultiShipment
		$secondShippingMethodSubtotalPriceReviewOrderForMultiShipment = $I->grabTextFrom("//div[@class='block-content'][position()=2]//td[@class='amount'][contains(@data-th,'Shipping & Handling')]//span[@class='price']"); // stepKey: secondShippingMethodSubtotalPriceReviewOrderForMultiShipment
		$I->assertEquals("$secondShippingMethodSubtotalPriceReviewOrderForMultiShipment", "$secondShippingMethodBasePriceReviewOrderForMultiShipment"); // stepKey: assertSecondShippingMethodPriceReviewOrderForMultiShipment
		$I->comment("Exiting Action Group [reviewOrderForMultiShipment] ReviewOrderForMultiShipmentActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForPlaceOrderPageLoad
		$I->comment("Entering Action Group [placeOrder] StorefrontPlaceOrderForMultipleAddressesActionGroup");
		$I->click("#review-button"); // stepKey: checkoutMultiShipmentPlaceOrderPlaceOrder
		$I->waitForPageLoad(30); // stepKey: waitForSuccessfullyPlacedOrderPlaceOrder
		$I->see("Thank you for your purchase!", ".page-title"); // stepKey: waitForLoadSuccessPagePlaceOrder
		$getFirstOrderIdPlaceOrder = $I->grabTextFrom("//li[@class='shipping-list'][position()=1]//a"); // stepKey: getFirstOrderIdPlaceOrder
		$dataHrefForFirstOrderPlaceOrder = $I->grabAttributeFrom("//li[@class='shipping-list'][position()=1]//a", "href"); // stepKey: dataHrefForFirstOrderPlaceOrder
		$getSecondOrderIdPlaceOrder = $I->grabTextFrom("//li[@class='shipping-list'][position()=2]//a"); // stepKey: getSecondOrderIdPlaceOrder
		$dataHrefForSecondOrderPlaceOrder = $I->grabAttributeFrom("//li[@class='shipping-list'][position()=2]//a", "href"); // stepKey: dataHrefForSecondOrderPlaceOrder
		$I->comment("Exiting Action Group [placeOrder] StorefrontPlaceOrderForMultipleAddressesActionGroup");
	}
}
