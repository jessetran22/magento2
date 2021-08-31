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
 * @Title("MC-42802: Zero price product should not have negative discount amount in order")
 * @Description("Zero price product should not have negative discount amount in order<h3>Test files</h3>app/code/Magento/SalesRule/Test/Mftf/Test/StorefrontZeroPriceProductWithDiscountUsingCartPriceRuleTest.xml<br>")
 * @TestCaseId("MC-42802")
 * @group SalesRule
 */
class StorefrontZeroPriceProductWithDiscountUsingCartPriceRuleTestCest
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
		$I->comment("Log in");
		$I->comment("Entering Action Group [login] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLogin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLogin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLogin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLogin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLogin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLogin
		$I->comment("Exiting Action Group [login] AdminLoginActionGroup");
		$I->comment("Create 2 simple products");
		$simpleProduct1Fields['price'] = "33.50";
		$I->createEntity("simpleProduct1", "hook", "SimpleProduct2", [], $simpleProduct1Fields); // stepKey: simpleProduct1
		$simpleProduct2Fields['price'] = "0.00";
		$I->createEntity("simpleProduct2", "hook", "SimpleProduct2", [], $simpleProduct2Fields); // stepKey: simpleProduct2
		$I->comment("Create the sales rule");
		$I->createEntity("createSalesRule", "hook", "SalesRuleSpecificCouponAndByPercent25", [], []); // stepKey: createSalesRule
		$I->createEntity("createCouponForCartPriceRule", "hook", "SimpleSalesRuleCoupon", ["createSalesRule"], []); // stepKey: createCouponForCartPriceRule
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->deleteEntity("simpleProduct1", "hook"); // stepKey: DeleteSimpleProduct1
		$I->deleteEntity("simpleProduct2", "hook"); // stepKey: DeleteSimpleProduct2
		$I->deleteEntity("createSalesRule", "hook"); // stepKey: deleteSalesRule
		$I->comment("Entering Action Group [logout] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogout
		$I->comment("Exiting Action Group [logout] AdminLogoutActionGroup");
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
	 * @Features({"SalesRule"})
	 * @Stories({"Create cart price rule"})
	 * @Severity(level = SeverityLevel::TRIVIAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StorefrontZeroPriceProductWithDiscountUsingCartPriceRuleTest(AcceptanceTester $I)
	{
		$I->comment("Add the first product to the cart");
		$I->comment("Entering Action Group [goToProductPage1] StorefrontOpenProductEntityPageActionGroup");
		$I->amOnPage("/" . $I->retrieveEntityField('simpleProduct1', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: goToProductPageGoToProductPage1
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoadedGoToProductPage1
		$I->comment("Exiting Action Group [goToProductPage1] StorefrontOpenProductEntityPageActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoad1
		$I->comment("Entering Action Group [addToCartFromStorefrontProductPage] StorefrontClickAddToCartOnProductPageActionGroup");
		$I->click("#product-addtocart-button"); // stepKey: addToCartAddToCartFromStorefrontProductPage
		$I->waitForPageLoad(60); // stepKey: addToCartAddToCartFromStorefrontProductPageWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForAddToCartAddToCartFromStorefrontProductPage
		$I->waitForElementVisible("div.message-success.success.message", 30); // stepKey: waitForSuccessMessageAddToCartFromStorefrontProductPage
		$I->comment("Exiting Action Group [addToCartFromStorefrontProductPage] StorefrontClickAddToCartOnProductPageActionGroup");
		$I->comment("Add the second product to the cart");
		$I->comment("Entering Action Group [goToProductPage2] StorefrontOpenProductEntityPageActionGroup");
		$I->amOnPage("/" . $I->retrieveEntityField('simpleProduct2', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: goToProductPageGoToProductPage2
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoadedGoToProductPage2
		$I->comment("Exiting Action Group [goToProductPage2] StorefrontOpenProductEntityPageActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoad2
		$I->comment("Entering Action Group [addToCartFromStorefrontProductPage2] StorefrontClickAddToCartOnProductPageActionGroup");
		$I->click("#product-addtocart-button"); // stepKey: addToCartAddToCartFromStorefrontProductPage2
		$I->waitForPageLoad(60); // stepKey: addToCartAddToCartFromStorefrontProductPage2WaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForAddToCartAddToCartFromStorefrontProductPage2
		$I->waitForElementVisible("div.message-success.success.message", 30); // stepKey: waitForSuccessMessageAddToCartFromStorefrontProductPage2
		$I->comment("Exiting Action Group [addToCartFromStorefrontProductPage2] StorefrontClickAddToCartOnProductPageActionGroup");
		$I->comment("Go to cart and apply coupon");
		$I->comment("Entering Action Group [clickMiniCart] ClickViewAndEditCartFromMiniCartActionGroup");
		$I->scrollTo("a.showcart"); // stepKey: scrollToMiniCartClickMiniCart
		$I->waitForPageLoad(60); // stepKey: scrollToMiniCartClickMiniCartWaitForPageLoad
		$I->conditionalClick("a.showcart", "a.showcart.active", false); // stepKey: openMiniCartClickMiniCart
		$I->waitForElementVisible(".action.viewcart", 30); // stepKey: waitForViewAndEditCartVisibleClickMiniCart
		$I->waitForPageLoad(30); // stepKey: waitForViewAndEditCartVisibleClickMiniCartWaitForPageLoad
		$I->click(".action.viewcart"); // stepKey: viewAndEditCartClickMiniCart
		$I->waitForPageLoad(30); // stepKey: viewAndEditCartClickMiniCartWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadClickMiniCart
		$I->seeInCurrentUrl("checkout/cart"); // stepKey: seeInCurrentUrlClickMiniCart
		$I->comment("Exiting Action Group [clickMiniCart] ClickViewAndEditCartFromMiniCartActionGroup");
		$I->comment("Entering Action Group [applyDiscount] StorefrontApplyCouponActionGroup");
		$I->waitForElement("#block-discount-heading", 30); // stepKey: waitForCouponHeaderApplyDiscount
		$I->conditionalClick("#block-discount-heading", ".block.discount.active", false); // stepKey: clickCouponHeaderApplyDiscount
		$I->waitForElementVisible("#coupon_code", 30); // stepKey: waitForCouponFieldApplyDiscount
		$I->fillField("#coupon_code", $I->retrieveEntityField('createCouponForCartPriceRule', 'code', 'test')); // stepKey: fillCouponFieldApplyDiscount
		$I->click("#discount-coupon-form button[class*='apply']"); // stepKey: clickApplyButtonApplyDiscount
		$I->waitForPageLoad(30); // stepKey: clickApplyButtonApplyDiscountWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadApplyDiscount
		$I->comment("Exiting Action Group [applyDiscount] StorefrontApplyCouponActionGroup");
		$I->comment("Assert Discount amount in storefront");
		$I->comment("Entering Action Group [seeDiscountTotal] AssertStorefrontCartDiscountActionGroup");
		$I->waitForElementVisible("td[data-th='Discount']", 30); // stepKey: waitForDiscountSeeDiscountTotal
		$I->see("-$8.38", "td[data-th='Discount']"); // stepKey: assertDiscountSeeDiscountTotal
		$I->comment("Exiting Action Group [seeDiscountTotal] AssertStorefrontCartDiscountActionGroup");
		$I->comment("Go to Checkout page");
		$I->comment("Entering Action Group [goToShoppingCartFromMinicart] ClickViewAndEditCartFromMiniCartActionGroup");
		$I->scrollTo("a.showcart"); // stepKey: scrollToMiniCartGoToShoppingCartFromMinicart
		$I->waitForPageLoad(60); // stepKey: scrollToMiniCartGoToShoppingCartFromMinicartWaitForPageLoad
		$I->conditionalClick("a.showcart", "a.showcart.active", false); // stepKey: openMiniCartGoToShoppingCartFromMinicart
		$I->waitForElementVisible(".action.viewcart", 30); // stepKey: waitForViewAndEditCartVisibleGoToShoppingCartFromMinicart
		$I->waitForPageLoad(30); // stepKey: waitForViewAndEditCartVisibleGoToShoppingCartFromMinicartWaitForPageLoad
		$I->click(".action.viewcart"); // stepKey: viewAndEditCartGoToShoppingCartFromMinicart
		$I->waitForPageLoad(30); // stepKey: viewAndEditCartGoToShoppingCartFromMinicartWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadGoToShoppingCartFromMinicart
		$I->seeInCurrentUrl("checkout/cart"); // stepKey: seeInCurrentUrlGoToShoppingCartFromMinicart
		$I->comment("Exiting Action Group [goToShoppingCartFromMinicart] ClickViewAndEditCartFromMiniCartActionGroup");
		$I->comment("Entering Action Group [clickProceedToCheckout] StorefrontClickProceedToCheckoutActionGroup");
		$I->click(".action.primary.checkout span"); // stepKey: goToCheckoutClickProceedToCheckout
		$I->waitForPageLoad(30); // stepKey: goToCheckoutClickProceedToCheckoutWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadClickProceedToCheckout
		$I->comment("Exiting Action Group [clickProceedToCheckout] StorefrontClickProceedToCheckoutActionGroup");
		$I->comment("Fill email field and addresses form and go next");
		$I->comment("Entering Action Group [guestCheckoutFillingShipping] GuestCheckoutFillingShippingSectionActionGroup");
		$I->waitForElementVisible("input[id*=customer-email]", 30); // stepKey: waitForEmailFieldGuestCheckoutFillingShipping
		$I->fillField("input[id*=customer-email]", msq("CustomerEntityOne") . "test@email.com"); // stepKey: enterEmailGuestCheckoutFillingShipping
		$I->fillField("input[name=firstname]", "John"); // stepKey: enterFirstNameGuestCheckoutFillingShipping
		$I->fillField("input[name=lastname]", "Doe"); // stepKey: enterLastNameGuestCheckoutFillingShipping
		$I->fillField("input[name='street[0]']", "7700 W Parmer Ln"); // stepKey: enterStreetGuestCheckoutFillingShipping
		$I->fillField("input[name=city]", "Austin"); // stepKey: enterCityGuestCheckoutFillingShipping
		$I->selectOption("select[name=region_id]", "Texas"); // stepKey: selectRegionGuestCheckoutFillingShipping
		$I->fillField("input[name=postcode]", "78729"); // stepKey: enterPostcodeGuestCheckoutFillingShipping
		$I->fillField("input[name=telephone]", "1234568910"); // stepKey: enterTelephoneGuestCheckoutFillingShipping
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskGuestCheckoutFillingShipping
		$I->waitForElement("//div[@id='checkout-shipping-method-load']//td[contains(., 'Flat Rate')]/..//input", 30); // stepKey: waitForShippingMethodGuestCheckoutFillingShipping
		$I->click("//div[@id='checkout-shipping-method-load']//td[contains(., 'Flat Rate')]/..//input"); // stepKey: selectShippingMethodGuestCheckoutFillingShipping
		$I->waitForElement("button.button.action.continue.primary", 30); // stepKey: waitForNextButtonGuestCheckoutFillingShipping
		$I->waitForPageLoad(30); // stepKey: waitForNextButtonGuestCheckoutFillingShippingWaitForPageLoad
		$I->click("button.button.action.continue.primary"); // stepKey: clickNextGuestCheckoutFillingShipping
		$I->waitForPageLoad(30); // stepKey: clickNextGuestCheckoutFillingShippingWaitForPageLoad
		$I->waitForElement("//*[@id='checkout-payment-method-load']//div[@data-role='title']", 30); // stepKey: waitForPaymentSectionLoadedGuestCheckoutFillingShipping
		$I->seeInCurrentUrl("/checkout/#payment"); // stepKey: assertCheckoutPaymentUrlGuestCheckoutFillingShipping
		$I->comment("Exiting Action Group [guestCheckoutFillingShipping] GuestCheckoutFillingShippingSectionActionGroup");
		$I->comment("Place Order");
		$I->comment("Entering Action Group [clickOnPlaceOrder] ClickPlaceOrderActionGroup");
		$I->waitForElement(".payment-method._active button.action.primary.checkout", 30); // stepKey: waitForPlaceOrderButtonClickOnPlaceOrder
		$I->waitForPageLoad(30); // stepKey: waitForPlaceOrderButtonClickOnPlaceOrderWaitForPageLoad
		$I->click(".payment-method._active button.action.primary.checkout"); // stepKey: clickPlaceOrderClickOnPlaceOrder
		$I->waitForPageLoad(30); // stepKey: clickPlaceOrderClickOnPlaceOrderWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCheckoutClickOnPlaceOrder
		$I->see("Thank you for your purchase!", ".page-title"); // stepKey: waitForLoadSuccessPageClickOnPlaceOrder
		$I->comment("Exiting Action Group [clickOnPlaceOrder] ClickPlaceOrderActionGroup");
		$grabOrderNumber = $I->grabTextFrom("div.checkout-success > p:nth-child(1) > span"); // stepKey: grabOrderNumber
		$I->comment("Navigate to admin order details page");
		$I->comment("Entering Action Group [openOrderById] AdminOpenOrderByEntityIdActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/sales/order/view/order_id/$grabOrderNumber"); // stepKey: openOrderOpenOrderById
		$I->comment("Exiting Action Group [openOrderById] AdminOpenOrderByEntityIdActionGroup");
		$I->comment("Assert Discount amount in admin");
		$I->see("$8.38", "//table[contains(@class,'edit-order-table')]//div[contains(text(),'" . $I->retrieveEntityField('simpleProduct1', 'name', 'test') . "')]/ancestor::tr//td[contains(@class, 'col-discont')]//span"); // stepKey: seeProduct1DiscountAmount
		$I->see("$0.00", "//table[contains(@class,'edit-order-table')]//div[contains(text(),'" . $I->retrieveEntityField('simpleProduct2', 'name', 'test') . "')]/ancestor::tr//td[contains(@class, 'col-discont')]//span"); // stepKey: seeProduct2DiscountAmount
		$I->see("-$8.38", ".order-subtotal-table tbody tr.col-1>td span.price"); // stepKey: seeDiscountAmount
	}
}
