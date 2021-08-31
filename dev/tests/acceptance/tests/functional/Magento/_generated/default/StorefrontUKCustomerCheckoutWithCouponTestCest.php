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
 * @Title("MC-14705: Verify UK customer checkout with Virtual and Downloadable products using coupon")
 * @Description("Checkout as UK Customer with virtual product and downloadable product using coupon<h3>Test files</h3>app/code/Magento/Checkout/Test/Mftf/Test/StorefrontUKCustomerCheckoutWithCouponTest.xml<br>")
 * @TestCaseId("MC-14705")
 * @group mtf_migrated
 */
class StorefrontUKCustomerCheckoutWithCouponTestCest
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
		$addDownloadableDomain = $I->magentoCLI("downloadable:domains:add", 60, "example.com static.magento.com"); // stepKey: addDownloadableDomain
		$I->comment($addDownloadableDomain);
		$createDownloadableProductFields['price'] = "20.00";
		$I->createEntity("createDownloadableProduct", "hook", "ApiDownloadableProduct", [], $createDownloadableProductFields); // stepKey: createDownloadableProduct
		$I->createEntity("addDownloadableLink1", "hook", "downloadableLink1", ["createDownloadableProduct"], []); // stepKey: addDownloadableLink1
		$I->createEntity("addDownloadableLink2", "hook", "downloadableLink2", ["createDownloadableProduct"], []); // stepKey: addDownloadableLink2
		$virtualProductFields['price'] = "10.00";
		$I->createEntity("virtualProduct", "hook", "VirtualProduct", [], $virtualProductFields); // stepKey: virtualProduct
		$I->createEntity("createCustomer", "hook", "UKCustomer", [], []); // stepKey: createCustomer
		$I->createEntity("createSalesRule", "hook", "SalesRuleSpecificCouponAndByPercent", [], []); // stepKey: createSalesRule
		$I->createEntity("createCouponForCartPriceRule", "hook", "SimpleSalesRuleCoupon", ["createSalesRule"], []); // stepKey: createCouponForCartPriceRule
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$removeDownloadableDomain = $I->magentoCLI("downloadable:domains:remove", 60, "example.com static.magento.com"); // stepKey: removeDownloadableDomain
		$I->comment($removeDownloadableDomain);
		$I->deleteEntity("createDownloadableProduct", "hook"); // stepKey: deleteProduct
		$I->deleteEntity("virtualProduct", "hook"); // stepKey: deleteVirtualProduct
		$I->deleteEntity("createCustomer", "hook"); // stepKey: deleteCustomer
		$I->deleteEntity("createSalesRule", "hook"); // stepKey: deleteSalesRule
		$I->comment("Entering Action Group [clearOrderFilters] AdminOrdersGridClearFiltersActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/sales/order/"); // stepKey: goToGridOrdersPageClearOrderFilters
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadClearOrderFilters
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header .admin__data-grid-filters-current._show", true); // stepKey: clickOnButtonToRemoveFiltersIfPresentClearOrderFilters
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitAfterClearFiltersClearOrderFilters
		$I->comment("Exiting Action Group [clearOrderFilters] AdminOrdersGridClearFiltersActionGroup");
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
	 * @Stories({"Checkout"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Features({"Checkout"})
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StorefrontUKCustomerCheckoutWithCouponTest(AcceptanceTester $I)
	{
		$I->comment("Open Downloadable Product page");
		$I->amOnPage("/" . $I->retrieveEntityField('createDownloadableProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: OpenStoreFrontProductPage
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoad
		$I->comment("Add Downloadable product to the cart");
		$I->comment("Entering Action Group [addToTheCart] StorefrontAddToCartCustomOptionsProductPageActionGroup");
		$I->click("#product-addtocart-button"); // stepKey: addToCartAddToTheCart
		$I->waitForPageLoad(60); // stepKey: addToCartAddToTheCartWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAddToTheCart
		$I->waitForElementVisible("div.message-success.success.message", 30); // stepKey: waitForSuccessMessageAddToTheCart
		$I->see("You added " . $I->retrieveEntityField('createDownloadableProduct', 'name', 'test') . " to your shopping cart.", "div.message-success.success.message"); // stepKey: seeAddToCartSuccessMessageAddToTheCart
		$I->comment("Exiting Action Group [addToTheCart] StorefrontAddToCartCustomOptionsProductPageActionGroup");
		$I->comment("Open Product page in StoreFront and assert product and price range");
		$I->comment("Entering Action Group [openVirtualProductPageAndVerifyProduct] AssertProductNameAndSkuInStorefrontProductPageByCustomAttributeUrlKeyActionGroup");
		$I->comment("Go to storefront product page, assert product name and sku");
		$I->amOnPage($I->retrieveEntityField('virtualProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: navigateToProductPageOpenVirtualProductPageAndVerifyProduct
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad2OpenVirtualProductPageAndVerifyProduct
		$I->seeInTitle($I->retrieveEntityField('virtualProduct', 'name', 'test')); // stepKey: assertProductNameTitleOpenVirtualProductPageAndVerifyProduct
		$I->see($I->retrieveEntityField('virtualProduct', 'name', 'test'), ".base"); // stepKey: assertProductNameOpenVirtualProductPageAndVerifyProduct
		$I->see($I->retrieveEntityField('virtualProduct', 'sku', 'test'), ".product.attribute.sku>.value"); // stepKey: assertProductSkuOpenVirtualProductPageAndVerifyProduct
		$I->comment("Exiting Action Group [openVirtualProductPageAndVerifyProduct] AssertProductNameAndSkuInStorefrontProductPageByCustomAttributeUrlKeyActionGroup");
		$I->comment("Add Product to the cart");
		$I->comment("Entering Action Group [addProduct1ToTheCart] AddToCartFromStorefrontProductPageActionGroup");
		$I->click("#product-addtocart-button"); // stepKey: addToCartAddProduct1ToTheCart
		$I->waitForPageLoad(60); // stepKey: addToCartAddProduct1ToTheCartWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForAddToCartAddProduct1ToTheCart
		$I->waitForElementNotVisible("//button/span[text()='Adding...']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddingAddProduct1ToTheCart
		$I->waitForElementNotVisible("//button/span[text()='Added']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddedAddProduct1ToTheCart
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAddProduct1ToTheCart
		$I->waitForElementVisible("div.message-success.success.message", 30); // stepKey: waitForSuccessMessageAddProduct1ToTheCart
		$I->see("You added " . $I->retrieveEntityField('virtualProduct', 'name', 'test') . " to your shopping cart.", "div.message-success.success.message"); // stepKey: seeAddToCartSuccessMessageAddProduct1ToTheCart
		$I->comment("Exiting Action Group [addProduct1ToTheCart] AddToCartFromStorefrontProductPageActionGroup");
		$I->comment("Open View and edit");
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
		$I->comment("Apply Coupon");
		$I->comment("Entering Action Group [applyDiscount] StorefrontApplyCouponActionGroup");
		$I->waitForElement("#block-discount-heading", 30); // stepKey: waitForCouponHeaderApplyDiscount
		$I->conditionalClick("#block-discount-heading", ".block.discount.active", false); // stepKey: clickCouponHeaderApplyDiscount
		$I->waitForElementVisible("#coupon_code", 30); // stepKey: waitForCouponFieldApplyDiscount
		$I->fillField("#coupon_code", $I->retrieveEntityField('createCouponForCartPriceRule', 'code', 'test')); // stepKey: fillCouponFieldApplyDiscount
		$I->click("#discount-coupon-form button[class*='apply']"); // stepKey: clickApplyButtonApplyDiscount
		$I->waitForPageLoad(30); // stepKey: clickApplyButtonApplyDiscountWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadApplyDiscount
		$I->comment("Exiting Action Group [applyDiscount] StorefrontApplyCouponActionGroup");
		$I->comment("Assert Discount and proceed to checkout");
		$I->comment("Adding the comment to replace action for preserving Backward Compatibility");
		$I->comment("Entering Action Group [seeDiscountTotal] AssertStorefrontCartDiscountActionGroup");
		$I->waitForElementVisible("td[data-th='Discount']", 30); // stepKey: waitForDiscountSeeDiscountTotal
		$I->see("-$15.00", "td[data-th='Discount']"); // stepKey: assertDiscountSeeDiscountTotal
		$I->comment("Exiting Action Group [seeDiscountTotal] AssertStorefrontCartDiscountActionGroup");
		$I->comment("Entering Action Group [goToCheckout] StorefrontClickProceedToCheckoutActionGroup");
		$I->click(".action.primary.checkout span"); // stepKey: goToCheckoutGoToCheckout
		$I->waitForPageLoad(30); // stepKey: goToCheckoutGoToCheckoutWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadGoToCheckout
		$I->comment("Exiting Action Group [goToCheckout] StorefrontClickProceedToCheckoutActionGroup");
		$I->comment("Adding the comment to replace waitForPageToLoad1 action for preserving Backward Compatibility");
		$I->comment("Fill the pop up sign form");
		$I->comment("Entering Action Group [customerSignIn] StorefrontCustomerSignInPopUpActionGroup");
		$I->waitForElementVisible("#customer-email", 30); // stepKey: waitForElementToBeVisibleCustomerSignIn
		$I->fillField("#customer-email", $I->retrieveEntityField('createCustomer', 'email', 'test')); // stepKey: fillEmailCustomerSignIn
		$I->fillField("#pass", $I->retrieveEntityField('createCustomer', 'password', 'test')); // stepKey: fillPasswordCustomerSignIn
		$I->click("#send2"); // stepKey: clickSignInAccountButtonCustomerSignIn
		$I->waitForPageLoad(30); // stepKey: clickSignInAccountButtonCustomerSignInWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadCustomerSignIn
		$I->comment("Exiting Action Group [customerSignIn] StorefrontCustomerSignInPopUpActionGroup");
		$I->comment("Entering Action Group [goToCheckout1] StorefrontClickProceedToCheckoutActionGroup");
		$I->click(".action.primary.checkout span"); // stepKey: goToCheckoutGoToCheckout1
		$I->waitForPageLoad(30); // stepKey: goToCheckoutGoToCheckout1WaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadGoToCheckout1
		$I->comment("Exiting Action Group [goToCheckout1] StorefrontClickProceedToCheckoutActionGroup");
		$I->comment("Adding the comment to replace waitForShippingMethodSectionToLoad action for preserving Backward Compatibility");
		$I->comment("Click and open order summary tab");
		$I->conditionalClick(".title[role='tab']", ".title[aria-expanded='false']", true); // stepKey: clickOnOrderSummaryTab
		$I->waitForPageLoad(30); // stepKey: clickOnOrderSummaryTabWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoad5
		$I->comment("Assert Product displayed in Order Summary");
		$I->comment("Entering Action Group [assertProduct3InOrderSummary] StorefrontAssertProductDetailsInOrderSummaryActionGroup");
		$I->see($I->retrieveEntityField('virtualProduct', 'name', 'test'), ".product-item-name"); // stepKey: seeProductNameAssertProduct3InOrderSummary
		$I->see("1", ".value"); // stepKey: seeProductQtyAssertProduct3InOrderSummary
		$I->see("$10.00", ".price"); // stepKey: seeProductPriceAssertProduct3InOrderSummary
		$I->comment("Exiting Action Group [assertProduct3InOrderSummary] StorefrontAssertProductDetailsInOrderSummaryActionGroup");
		$I->waitForElementVisible(".payment-method._active .payment-method-billing-address .action.action-update", 30); // stepKey: waitForUpdateButton
		$I->waitForPageLoad(30); // stepKey: waitForUpdateButtonWaitForPageLoad
		$I->click(".payment-method._active .payment-method-billing-address .action.action-update"); // stepKey: clickOnUpdateButton
		$I->waitForPageLoad(30); // stepKey: clickOnUpdateButtonWaitForPageLoad
		$I->comment("Place the order and Verify Success message");
		$I->comment("Entering Action Group [clickOnPlaceOrder] ClickPlaceOrderActionGroup");
		$I->waitForElement(".payment-method._active button.action.primary.checkout", 30); // stepKey: waitForPlaceOrderButtonClickOnPlaceOrder
		$I->waitForPageLoad(30); // stepKey: waitForPlaceOrderButtonClickOnPlaceOrderWaitForPageLoad
		$I->click(".payment-method._active button.action.primary.checkout"); // stepKey: clickPlaceOrderClickOnPlaceOrder
		$I->waitForPageLoad(30); // stepKey: clickPlaceOrderClickOnPlaceOrderWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCheckoutClickOnPlaceOrder
		$I->see("Thank you for your purchase!", ".page-title"); // stepKey: waitForLoadSuccessPageClickOnPlaceOrder
		$I->comment("Exiting Action Group [clickOnPlaceOrder] ClickPlaceOrderActionGroup");
		$I->comment("Assert empty Mini Cart");
		$I->seeElement("//div[@class='minicart-wrapper']//span[@class='counter qty empty']/../.."); // stepKey: assertEmptyCart
		$orderId = $I->grabTextFrom("a[href*=order_id].order-number"); // stepKey: orderId
		$I->waitForPageLoad(30); // stepKey: orderIdWaitForPageLoad
		$I->comment("Login to Admin Page");
		$I->comment("Entering Action Group [loginToAdminPanel] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginToAdminPanel
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginToAdminPanel
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginToAdminPanel
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginToAdminPanel
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginToAdminPanelWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginToAdminPanel
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginToAdminPanel
		$I->comment("Exiting Action Group [loginToAdminPanel] AdminLoginActionGroup");
		$I->comment("Open Order Index Page");
		$I->comment("Entering Action Group [goToOrders] AdminOrdersPageOpenActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/sales/order/"); // stepKey: openOrdersGridPageGoToOrders
		$I->waitForPageLoad(30); // stepKey: waitForLoadingPageGoToOrders
		$I->comment("Exiting Action Group [goToOrders] AdminOrdersPageOpenActionGroup");
		$I->comment("Filter Order using orderId and assert order");
		$I->comment("Entering Action Group [filterOrderGridById] FilterOrderGridByIdActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/sales/order/"); // stepKey: navigateToOrderGridPageFilterOrderGridById
		$I->waitForPageLoad(30); // stepKey: waitForOrdersPageFilterOrderGridById
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clearExistingOrderFiltersFilterOrderGridById
		$I->waitForPageLoad(30); // stepKey: clearExistingOrderFiltersFilterOrderGridByIdWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForClearFiltersFilterOrderGridById
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openOrderGridFiltersFilterOrderGridById
		$I->waitForPageLoad(30); // stepKey: openOrderGridFiltersFilterOrderGridByIdWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForClickFiltersFilterOrderGridById
		$I->fillField(".admin__data-grid-filters input[name='increment_id']", "$orderId"); // stepKey: fillOrderIdFilterFilterOrderGridById
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickOrderApplyFiltersFilterOrderGridById
		$I->waitForPageLoad(30); // stepKey: clickOrderApplyFiltersFilterOrderGridByIdWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForApplyFiltersFilterOrderGridById
		$I->comment("Exiting Action Group [filterOrderGridById] FilterOrderGridByIdActionGroup");
		$I->see($I->retrieveEntityField('createCustomer', 'fullname', 'test'), "tr.data-row:nth-of-type(1)"); // stepKey: seeCustomerNameInGrid
		$I->see("$15.00", "tr.data-row:nth-of-type(1)"); // stepKey: seeGrandTotalInGrid
		$I->see("Pending", "tr.data-row:nth-of-type(1)"); // stepKey: seeStatusIdInGrid
		$I->click("//td/div[contains(.,'$orderId')]/../..//a[@class='action-menu-item']"); // stepKey: clickOnOrderViewLink
		$I->waitForPageLoad(30); // stepKey: waitForOrderPageToLoad
		$I->comment("Assert order buttons");
		$I->comment("Entering Action Group [assertOrderButtons] AdminAssertOrderAvailableButtonsActionGroup");
		$I->seeElement("#back"); // stepKey: seeBackButtonAssertOrderButtons
		$I->waitForPageLoad(30); // stepKey: seeBackButtonAssertOrderButtonsWaitForPageLoad
		$I->seeElement("#order-view-cancel-button"); // stepKey: seeCancelButtonAssertOrderButtons
		$I->waitForPageLoad(30); // stepKey: seeCancelButtonAssertOrderButtonsWaitForPageLoad
		$I->seeElement("#send_notification"); // stepKey: seeSendEmailButtonAssertOrderButtons
		$I->waitForPageLoad(30); // stepKey: seeSendEmailButtonAssertOrderButtonsWaitForPageLoad
		$I->seeElement("#order-view-hold-button"); // stepKey: seeHoldButtonAssertOrderButtons
		$I->waitForPageLoad(30); // stepKey: seeHoldButtonAssertOrderButtonsWaitForPageLoad
		$I->seeElement("#order_invoice"); // stepKey: seeInvoiceButtonAssertOrderButtons
		$I->waitForPageLoad(30); // stepKey: seeInvoiceButtonAssertOrderButtonsWaitForPageLoad
		$I->seeElement("#order_reorder"); // stepKey: seeReorderButtonAssertOrderButtons
		$I->waitForPageLoad(30); // stepKey: seeReorderButtonAssertOrderButtonsWaitForPageLoad
		$I->seeElement("#order_edit"); // stepKey: seeEditButtonAssertOrderButtons
		$I->waitForPageLoad(30); // stepKey: seeEditButtonAssertOrderButtonsWaitForPageLoad
		$I->comment("Exiting Action Group [assertOrderButtons] AdminAssertOrderAvailableButtonsActionGroup");
		$I->comment("Assert Grand Total");
		$I->see("$15.00", ".order-subtotal-table tfoot tr.col-0>td span.price"); // stepKey: seeGrandTotal
		$I->see("Pending", ".order-information table.order-information-table #order_status"); // stepKey: seeOrderStatus
	}
}
