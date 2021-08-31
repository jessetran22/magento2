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
 * @Title("MC-21923: Create Cart Price Rule for Free Shipping And Verify Coupon Code will shown in Order's totals")
 * @Description("Test that Coupon Code of Cart Price Rule without discount for Product price but with Free shipping will shown in Order's totals<h3>Test files</h3>app/code/Magento/SalesRule/Test/Mftf/Test/StorefrontCartRuleCouponForFreeShippingTest.xml<br>")
 * @TestCaseId("MC-21923")
 * @group SalesRule
 */
class StorefrontCartRuleCouponForFreeShippingTestCest
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
		$I->comment("Create Simple Product");
		$I->createEntity("createSimpleProduct", "hook", "defaultSimpleProduct", [], []); // stepKey: createSimpleProduct
		$I->comment("Create Cart Price Rule without discount but with free shipping");
		$createCartPriceRuleFields['simple_free_shipping'] = "1";
		$createCartPriceRuleFields['discount_amount'] = "0";
		$I->createEntity("createCartPriceRule", "hook", "ApiSalesRule", [], $createCartPriceRuleFields); // stepKey: createCartPriceRule
		$I->comment("Create Coupon code for the Cart Price Rule");
		$I->createEntity("createCartPriceRuleCoupon", "hook", "ApiSalesRuleCoupon", ["createCartPriceRule"], []); // stepKey: createCartPriceRuleCoupon
		$I->comment("Create Customer with filled Shipping & Billing Address");
		$I->createEntity("createCustomer", "hook", "CustomerEntityOne", [], []); // stepKey: createCustomer
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [logoutFromStorefront] StorefrontCustomerLogoutActionGroup");
		$I->amOnPage("customer/account/logout/"); // stepKey: storefrontSignOutLogoutFromStorefront
		$I->waitForPageLoad(30); // stepKey: waitForSignOutLogoutFromStorefront
		$I->comment("Exiting Action Group [logoutFromStorefront] StorefrontCustomerLogoutActionGroup");
		$I->deleteEntity("createCartPriceRule", "hook"); // stepKey: deleteSalesRule
		$I->deleteEntity("createCustomer", "hook"); // stepKey: deleteCustomer
		$I->deleteEntity("createSimpleProduct", "hook"); // stepKey: deleteProduct
		$I->comment("Entering Action Group [logoutFromBackend] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogoutFromBackend
		$I->comment("Exiting Action Group [logoutFromBackend] AdminLogoutActionGroup");
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
	 * @Stories({"Create Sales Rule"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Features({"SalesRule"})
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StorefrontCartRuleCouponForFreeShippingTest(AcceptanceTester $I)
	{
		$I->comment("Login with created Customer");
		$I->comment("Entering Action Group [loginAsCustomer] LoginToStorefrontActionGroup");
		$I->amOnPage("/customer/account/login/"); // stepKey: amOnSignInPageLoginAsCustomer
		$I->waitForPageLoad(30); // stepKey: waitPageFullyLoadedLoginAsCustomer
		$I->waitForElementVisible("#email", 30); // stepKey: waitFormAppearsLoginAsCustomer
		$I->fillField("#email", $I->retrieveEntityField('createCustomer', 'email', 'test')); // stepKey: fillEmailLoginAsCustomer
		$I->fillField("#pass", $I->retrieveEntityField('createCustomer', 'password', 'test')); // stepKey: fillPasswordLoginAsCustomer
		$I->click("#send2"); // stepKey: clickSignInAccountButtonLoginAsCustomer
		$I->waitForPageLoad(30); // stepKey: clickSignInAccountButtonLoginAsCustomerWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCustomerLoggedInLoginAsCustomer
		$I->comment("Exiting Action Group [loginAsCustomer] LoginToStorefrontActionGroup");
		$I->comment("Add Simple Product to Cart");
		$I->comment("Entering Action Group [addProductToCart] StorefrontAddSimpleProductToShoppingCartActionGroup");
		$I->amOnPage("/" . $I->retrieveEntityField('createSimpleProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: openProductPageAddProductToCart
		$I->waitForPageLoad(30); // stepKey: waitForProductPageOpenAddProductToCart
		$I->fillField("#qty", "1"); // stepKey: fillQtyAddProductToCart
		$I->click("button#product-addtocart-button"); // stepKey: clickAddToCartAddProductToCart
		$I->waitForElementVisible(".messages .message-success", 30); // stepKey: waitForSuccessMessageAddProductToCart
		$I->comment("Exiting Action Group [addProductToCart] StorefrontAddSimpleProductToShoppingCartActionGroup");
		$I->comment("Go to Checkout");
		$I->comment("Entering Action Group [goToCheckout] GoToCheckoutFromMinicartActionGroup");
		$I->waitForElementNotVisible(".counter.qty.empty", 30); // stepKey: waitUpdateQuantityGoToCheckout
		$I->wait(5); // stepKey: waitMinicartRenderingGoToCheckout
		$I->click("a.showcart"); // stepKey: clickCartGoToCheckout
		$I->waitForPageLoad(60); // stepKey: clickCartGoToCheckoutWaitForPageLoad
		$I->click("#top-cart-btn-checkout"); // stepKey: goToCheckoutGoToCheckout
		$I->waitForPageLoad(30); // stepKey: goToCheckoutGoToCheckoutWaitForPageLoad
		$I->comment("Exiting Action Group [goToCheckout] GoToCheckoutFromMinicartActionGroup");
		$I->comment("Go to Order review");
		$I->comment("Entering Action Group [goToCheckoutReview] StorefrontCheckoutForwardFromShippingStepActionGroup");
		$I->waitForElementVisible("button.button.action.continue.primary", 30); // stepKey: waitForNextButtonGoToCheckoutReview
		$I->waitForPageLoad(30); // stepKey: waitForNextButtonGoToCheckoutReviewWaitForPageLoad
		$I->click("button.button.action.continue.primary"); // stepKey: clickNextGoToCheckoutReview
		$I->waitForPageLoad(30); // stepKey: clickNextGoToCheckoutReviewWaitForPageLoad
		$I->comment("Exiting Action Group [goToCheckoutReview] StorefrontCheckoutForwardFromShippingStepActionGroup");
		$I->comment("Apply Discount Coupon to the Order");
		$I->comment("Entering Action Group [applyDiscountCoupon] StorefrontApplyDiscountCodeActionGroup");
		$I->conditionalClick("//*[text()='Apply Discount Code']", "#coupon_code", false); // stepKey: clickToAddDiscountApplyDiscountCoupon
		$I->fillField("#discount-code", $I->retrieveEntityField('createCartPriceRuleCoupon', 'code', 'test')); // stepKey: fillFieldDiscountCodeApplyDiscountCoupon
		$I->click("//span[text()='Apply Discount']"); // stepKey: clickToApplyDiscountApplyDiscountCoupon
		$I->waitForElementVisible(".message-success div", 30); // stepKey: waitForDiscountToBeAddedApplyDiscountCoupon
		$I->see("Your coupon was successfully applied", ".message-success div"); // stepKey: assertDiscountApplyMessageApplyDiscountCoupon
		$I->comment("Exiting Action Group [applyDiscountCoupon] StorefrontApplyDiscountCodeActionGroup");
		$I->comment("Assert Coupon Code will shown in Shipping total");
		$I->comment("Entering Action Group [assertCouponCodeInShippingLabel] AssertStorefrontShippingLabelDescriptionInOrderSummaryActionGroup");
		$I->waitForElementVisible(".shipping.totals .label.description", 30); // stepKey: waitForElementAssertCouponCodeInShippingLabel
		$I->see($I->retrieveEntityField('createCartPriceRuleCoupon', 'code', 'test'), ".shipping.totals .label.description"); // stepKey: seeShippingMethodLabelDescriptionAssertCouponCodeInShippingLabel
		$I->comment("Exiting Action Group [assertCouponCodeInShippingLabel] AssertStorefrontShippingLabelDescriptionInOrderSummaryActionGroup");
		$I->comment("Select payment solution");
		$I->comment("Entering Action Group [clickCheckMoneyOrderPayment] CheckoutSelectCheckMoneyOrderPaymentActionGroup");
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskClickCheckMoneyOrderPayment
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadClickCheckMoneyOrderPayment
		$I->conditionalClick("//div[@id='checkout-payment-method-load']//div[@class='payment-method']//label//span[contains(., 'Check / Money order')]/../..//input", "//div[@id='checkout-payment-method-load']//div[@class='payment-method']//label//span[contains(., 'Check / Money order')]/../..//input", true); // stepKey: selectCheckmoPaymentMethodClickCheckMoneyOrderPayment
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskAfterPaymentMethodSelectionClickCheckMoneyOrderPayment
		$I->comment("Exiting Action Group [clickCheckMoneyOrderPayment] CheckoutSelectCheckMoneyOrderPaymentActionGroup");
		$I->comment("Place Order");
		$I->comment("Entering Action Group [placeOrder] ClickPlaceOrderActionGroup");
		$I->waitForElement(".payment-method._active button.action.primary.checkout", 30); // stepKey: waitForPlaceOrderButtonPlaceOrder
		$I->waitForPageLoad(30); // stepKey: waitForPlaceOrderButtonPlaceOrderWaitForPageLoad
		$I->click(".payment-method._active button.action.primary.checkout"); // stepKey: clickPlaceOrderPlaceOrder
		$I->waitForPageLoad(30); // stepKey: clickPlaceOrderPlaceOrderWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCheckoutPlaceOrder
		$I->see("Thank you for your purchase!", ".page-title"); // stepKey: waitForLoadSuccessPagePlaceOrder
		$I->comment("Exiting Action Group [placeOrder] ClickPlaceOrderActionGroup");
		$I->comment("Go To Order View");
		$I->click("a[href*=order_id].order-number"); // stepKey: goToViewOrder
		$I->waitForPageLoad(30); // stepKey: goToViewOrderWaitForPageLoad
		$I->comment("Assert Coupon Code will shown in Shipping total description in Order View page");
		$I->comment("Entering Action Group [assertCouponCodeInShippingTotalDescription] AssertStorefrontShippingDescriptionInOrderViewActionGroup");
		$I->waitForElementVisible("#my-orders-table tr.shipping th.mark", 30); // stepKey: waitForElementAssertCouponCodeInShippingTotalDescription
		$I->see($I->retrieveEntityField('createCartPriceRuleCoupon', 'code', 'test'), "#my-orders-table tr.shipping th.mark"); // stepKey: seeShippingTotalDescriptionAssertCouponCodeInShippingTotalDescription
		$I->comment("Exiting Action Group [assertCouponCodeInShippingTotalDescription] AssertStorefrontShippingDescriptionInOrderViewActionGroup");
		$I->comment("Keep Order Id");
		$grabOrderId = $I->grabFromCurrentUrl("~/order_id/(\d+)/~"); // stepKey: grabOrderId
		$I->comment("Login to admin");
		$I->comment("Entering Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdminWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin
		$I->comment("Exiting Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->comment("Go to created Order");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/sales/order/view/order_id/{$grabOrderId}"); // stepKey: goToAdminViewOrder
		$I->waitForPageLoad(30); // stepKey: waitForOrderPage
		$I->comment("Assert Coupon Code will shown in Shipping total description");
		$I->comment("Entering Action Group [seeCouponInShippingDescription] AssertAdminShippingDescriptionInOrderViewActionGroup");
		$I->waitForElementVisible("//table[contains(@class, 'order-subtotal-table')]//td[contains(text(), 'Shipping & Handling')]", 30); // stepKey: waitForElementSeeCouponInShippingDescription
		$I->see($I->retrieveEntityField('createCartPriceRuleCoupon', 'code', 'test'), "//table[contains(@class, 'order-subtotal-table')]//td[contains(text(), 'Shipping & Handling')]"); // stepKey: seeOrderTotalShippingDescriptionSeeCouponInShippingDescription
		$I->comment("Exiting Action Group [seeCouponInShippingDescription] AssertAdminShippingDescriptionInOrderViewActionGroup");
	}
}
