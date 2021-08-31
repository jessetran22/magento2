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
 * @Title("MAGETWO-94178: Checking status of Zero Subtotal Orders with 'Processing' New Order Status")
 * @Description("Created order should be in Processing status<h3>Test files</h3>app/code/Magento/Checkout/Test/Mftf/Test/ZeroSubtotalOrdersWithProcessingStatusTest.xml<br>")
 * @TestCaseId("MAGETWO-94178")
 * @group checkout
 */
class ZeroSubtotalOrdersWithProcessingStatusTestCest
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
		$I->createEntity("simplecategory", "hook", "SimpleSubCategory", [], []); // stepKey: simplecategory
		$I->createEntity("simpleproduct", "hook", "SimpleProduct", ["simplecategory"], []); // stepKey: simpleproduct
		$I->createEntity("paymentMethodsSettingConfig", "hook", "PaymentMethodsSettingConfig", [], []); // stepKey: paymentMethodsSettingConfig
		$I->createEntity("freeShippingMethodsSettingConfig", "hook", "FreeShippingMethodsSettingConfig", [], []); // stepKey: freeShippingMethodsSettingConfig
		$I->comment("Go to Admin page");
		$I->comment("Entering Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdminWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin
		$I->comment("Exiting Action Group [loginAsAdmin] AdminLoginActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [deleteSalesRule] DeleteCartPriceRuleByName");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/sales_rule/promo_quote/"); // stepKey: amOnCartPriceListDeleteSalesRule
		$I->waitForPageLoad(30); // stepKey: waitForPriceListDeleteSalesRule
		$I->fillField("input[name='name']", "salesRule" . msq("ApiSalesRule")); // stepKey: filterByNameDeleteSalesRule
		$I->click("#promo_quote_grid button[title='Search']"); // stepKey: doFilterDeleteSalesRule
		$I->waitForPageLoad(30); // stepKey: doFilterDeleteSalesRuleWaitForPageLoad
		$I->click("tr[data-role='row']:nth-of-type(1)"); // stepKey: goToEditRulePageDeleteSalesRule
		$I->waitForPageLoad(30); // stepKey: goToEditRulePageDeleteSalesRuleWaitForPageLoad
		$I->click("button#delete"); // stepKey: clickDeleteButtonDeleteSalesRule
		$I->waitForPageLoad(30); // stepKey: clickDeleteButtonDeleteSalesRuleWaitForPageLoad
		$I->click("button.action-accept"); // stepKey: confirmDeleteDeleteSalesRule
		$I->waitForPageLoad(30); // stepKey: confirmDeleteDeleteSalesRuleWaitForPageLoad
		$I->comment("Exiting Action Group [deleteSalesRule] DeleteCartPriceRuleByName");
		$I->createEntity("defaultShippingMethodsConfig", "hook", "DefaultShippingMethodsConfig", [], []); // stepKey: defaultShippingMethodsConfig
		$I->createEntity("disableFreeShippingConfig", "hook", "DisableFreeShippingConfig", [], []); // stepKey: disableFreeShippingConfig
		$I->createEntity("disablePaymentMethodsSettingConfig", "hook", "DisablePaymentMethodsSettingConfig", [], []); // stepKey: disablePaymentMethodsSettingConfig
		$I->comment("Entering Action Group [logout] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogout
		$I->comment("Exiting Action Group [logout] AdminLogoutActionGroup");
		$I->deleteEntity("simpleproduct", "hook"); // stepKey: deleteProduct
		$I->deleteEntity("simplecategory", "hook"); // stepKey: deleteCategory
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
	 * @Stories({"MAGETWO-71375: Zero Subtotal Orders have incorrect status"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function ZeroSubtotalOrdersWithProcessingStatusTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [amOnCartPriceList] AdminOpenCartPriceRulesPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/sales_rule/promo_quote/"); // stepKey: openCartPriceRulesPageAmOnCartPriceList
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAmOnCartPriceList
		$I->comment("Exiting Action Group [amOnCartPriceList] AdminOpenCartPriceRulesPageActionGroup");
		$I->comment("Add New Rule");
		$I->click("#add"); // stepKey: clickAddNewRule
		$I->waitForPageLoad(30); // stepKey: clickAddNewRuleWaitForPageLoad
		$I->fillField("input[name='name']", "salesRule" . msq("ApiSalesRule")); // stepKey: fillRuleName
		$I->selectOption("select[name='website_ids']", "Main Website"); // stepKey: selectWebsite
		$I->comment("Entering Action Group [chooseNotLoggedInCustomerGroup] SelectNotLoggedInCustomerGroupActionGroup");
		$I->comment("This actionGroup was created to be merged from B2B because B2B has a very different form control here");
		$I->selectOption("select[name='customer_group_ids']", "NOT LOGGED IN"); // stepKey: selectCustomerGroupChooseNotLoggedInCustomerGroup
		$I->comment("Exiting Action Group [chooseNotLoggedInCustomerGroup] SelectNotLoggedInCustomerGroupActionGroup");
		$date = new \DateTime();
		$date->setTimestamp(strtotime("-1 day"));
		$date->setTimezone(new \DateTimeZone("America/Los_Angeles"));
		$yesterdayDate = $date->format("m/d/Y");

		$I->fillField("input[name='from_date']", $yesterdayDate); // stepKey: fillFromDate
		$I->selectOption("select[name='coupon_type']", "Specific Coupon"); // stepKey: selectCouponType
		$I->fillField("input[name='coupon_code']", "defaultCoupon" . msq("_defaultCoupon")); // stepKey: fillCouponCode
		$I->fillField("//input[@name='uses_per_coupon']", "99"); // stepKey: fillUserPerCoupon
		$I->click("div[data-index='actions']"); // stepKey: clickToExpandActions
		$I->waitForPageLoad(30); // stepKey: clickToExpandActionsWaitForPageLoad
		$I->selectOption("select[name='simple_action']", "Percent of product price discount"); // stepKey: selectActionType
		$I->fillField("input[name='discount_amount']", "100"); // stepKey: fillDiscountAmount
		$I->click("#save"); // stepKey: clickSaveButton
		$I->waitForPageLoad(30); // stepKey: clickSaveButtonWaitForPageLoad
		$I->see("You saved the rule.", ".messages"); // stepKey: seeSuccessMessage
		$I->comment("Proceed to store front and place an order with free shipping using created coupon");
		$I->comment("Add product to card");
		$I->comment("Entering Action Group [AddProductToCard] AddSimpleProductToCartActionGroup");
		$I->amOnPage("/" . $I->retrieveEntityField('simpleproduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: goToProductPageAddProductToCard
		$I->waitForPageLoad(30); // stepKey: waitForProductPageAddProductToCard
		$I->click("button.action.tocart.primary"); // stepKey: addToCartAddProductToCard
		$I->waitForPageLoad(30); // stepKey: addToCartAddProductToCardWaitForPageLoad
		$I->waitForElementNotVisible("//button/span[text()='Adding...']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddingAddProductToCard
		$I->waitForElementNotVisible("//button/span[text()='Added']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddedAddProductToCard
		$I->waitForElementVisible("//button/span[text()='Add to Cart']", 30); // stepKey: waitForElementVisibleAddToCartButtonTitleIsAddToCartAddProductToCard
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAddProductToCard
		$I->waitForElementVisible("div.message-success.success.message", 30); // stepKey: waitForProductAddedMessageAddProductToCard
		$I->see("You added " . $I->retrieveEntityField('simpleproduct', 'name', 'test') . " to your shopping cart.", "div.message-success.success.message"); // stepKey: seeAddToCartSuccessMessageAddProductToCard
		$I->comment("Exiting Action Group [AddProductToCard] AddSimpleProductToCartActionGroup");
		$I->comment("Proceed to shipment");
		$I->comment("Entering Action Group [clickToOpenCard] StorefrontClickOnMiniCartActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollToTheTopOfThePageClickToOpenCard
		$I->waitForElementVisible("a.showcart", 30); // stepKey: waitForElementToBeVisibleClickToOpenCard
		$I->waitForPageLoad(60); // stepKey: waitForElementToBeVisibleClickToOpenCardWaitForPageLoad
		$I->click("a.showcart"); // stepKey: clickOnMiniCartClickToOpenCard
		$I->waitForPageLoad(60); // stepKey: clickOnMiniCartClickToOpenCardWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadClickToOpenCard
		$I->comment("Exiting Action Group [clickToOpenCard] StorefrontClickOnMiniCartActionGroup");
		$I->click("#top-cart-btn-checkout"); // stepKey: clickToProceedToCheckout
		$I->waitForPageLoad(30); // stepKey: clickToProceedToCheckoutWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForTheFormIsOpened
		$I->comment("Fill shipping form");
		$I->comment("Entering Action Group [shipmentFormFreeShippingActionGroup] ShipmentFormFreeShippingActionGroup");
		$I->fillField("input[id*=customer-email]", msq("CustomerEntityOne") . "test@email.com"); // stepKey: setCustomerEmailShipmentFormFreeShippingActionGroup
		$I->fillField("input[name=firstname]", "John"); // stepKey: SetCustomerFirstNameShipmentFormFreeShippingActionGroup
		$I->fillField("input[name=lastname]", "Doe"); // stepKey: SetCustomerLastNameShipmentFormFreeShippingActionGroup
		$I->fillField("input[name='street[0]']", "[\"7700 W Parmer Ln\",\"Bld D\"]"); // stepKey: SetCustomerStreetAddressShipmentFormFreeShippingActionGroup
		$I->fillField("input[name=city]", "Austin"); // stepKey: SetCustomerCityShipmentFormFreeShippingActionGroup
		$I->fillField("input[name=postcode]", "78729"); // stepKey: SetCustomerZipCodeShipmentFormFreeShippingActionGroup
		$I->fillField("input[name=telephone]", "1234568910"); // stepKey: SetCustomerPhoneNumberShipmentFormFreeShippingActionGroup
		$I->click("select[name=region_id]"); // stepKey: clickToSetStateShipmentFormFreeShippingActionGroup
		$I->click("//*[text()='Alabama']"); // stepKey: clickToChooseStateShipmentFormFreeShippingActionGroup
		$I->see("$0.00 Free Free Shipping", "//div[@id='checkout-shipping-method-load']//td[contains(., 'Free Shipping')]/.."); // stepKey: seeShippingMethodShipmentFormFreeShippingActionGroup
		$I->click("//div[@id='checkout-shipping-method-load']//td[contains(., 'Free Shipping')]/..//input"); // stepKey: selectFlatShippingMethodShipmentFormFreeShippingActionGroup
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskShipmentFormFreeShippingActionGroup
		$I->click("button.button.action.continue.primary"); // stepKey: clickToSaveShippingInfoShipmentFormFreeShippingActionGroup
		$I->waitForPageLoad(30); // stepKey: clickToSaveShippingInfoShipmentFormFreeShippingActionGroupWaitForPageLoad
		$I->waitForPageLoad(5); // stepKey: waitForReviewAndPaymentsPageIsLoadedShipmentFormFreeShippingActionGroup
		$I->seeInCurrentUrl("payment"); // stepKey: reviewAndPaymentIsShownShipmentFormFreeShippingActionGroup
		$I->comment("Exiting Action Group [shipmentFormFreeShippingActionGroup] ShipmentFormFreeShippingActionGroup");
		$I->click("//*[text()='Apply Discount Code']"); // stepKey: clickToAddDiscount
		$I->fillField("#discount-code", "defaultCoupon" . msq("_defaultCoupon")); // stepKey: TypeDiscountCode
		$I->click("//span[text()='Apply Discount']"); // stepKey: clickToApplyDiscount
		$I->waitForPageLoad(30); // stepKey: WaitForDiscountToBeAdded
		$I->see("Your coupon was successfully applied."); // stepKey: verifyText
		$I->comment("Comment is added to preserve the step key for backward compatibility");
		$I->comment("Entering Action Group [clickPlaceOrder] ClickPlaceOrderActionGroup");
		$I->waitForElement(".payment-method._active button.action.primary.checkout", 30); // stepKey: waitForPlaceOrderButtonClickPlaceOrder
		$I->waitForPageLoad(30); // stepKey: waitForPlaceOrderButtonClickPlaceOrderWaitForPageLoad
		$I->click(".payment-method._active button.action.primary.checkout"); // stepKey: clickPlaceOrderClickPlaceOrder
		$I->waitForPageLoad(30); // stepKey: clickPlaceOrderClickPlaceOrderWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCheckoutClickPlaceOrder
		$I->see("Thank you for your purchase!", ".page-title"); // stepKey: waitForLoadSuccessPageClickPlaceOrder
		$I->comment("Exiting Action Group [clickPlaceOrder] ClickPlaceOrderActionGroup");
		$grabOrderNumber = $I->grabTextFrom("div.checkout-success > p:nth-child(1) > span"); // stepKey: grabOrderNumber
		$I->comment("Proceed to Admin panel > SALES > Orders. Created order should be in Processing status");
		$I->amOnPage("/admin/sales/order/"); // stepKey: navigateToSalesOrderPage
		$I->waitForPageLoad(30); // stepKey: waitForSalesOrderPageLoaded
		$I->comment("Open Order");
		$I->comment("Entering Action Group [filterOrderGridById] FilterOrderGridByIdActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/sales/order/"); // stepKey: navigateToOrderGridPageFilterOrderGridById
		$I->waitForPageLoad(30); // stepKey: waitForOrdersPageFilterOrderGridById
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clearExistingOrderFiltersFilterOrderGridById
		$I->waitForPageLoad(30); // stepKey: clearExistingOrderFiltersFilterOrderGridByIdWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForClearFiltersFilterOrderGridById
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openOrderGridFiltersFilterOrderGridById
		$I->waitForPageLoad(30); // stepKey: openOrderGridFiltersFilterOrderGridByIdWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForClickFiltersFilterOrderGridById
		$I->fillField(".admin__data-grid-filters input[name='increment_id']", "$grabOrderNumber"); // stepKey: fillOrderIdFilterFilterOrderGridById
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickOrderApplyFiltersFilterOrderGridById
		$I->waitForPageLoad(30); // stepKey: clickOrderApplyFiltersFilterOrderGridByIdWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForApplyFiltersFilterOrderGridById
		$I->comment("Exiting Action Group [filterOrderGridById] FilterOrderGridByIdActionGroup");
		$I->comment("Entering Action Group [clickOrderRow] AdminOrderGridClickFirstRowActionGroup");
		$I->click("tr.data-row:nth-of-type(1)"); // stepKey: clickFirstOrderRowClickOrderRow
		$I->waitForPageLoad(30); // stepKey: waitForOrderPageLoadClickOrderRow
		$I->comment("Exiting Action Group [clickOrderRow] AdminOrderGridClickFirstRowActionGroup");
		$I->comment("Verify that Created order is in Processing status");
		$I->see("Processing", ".order-information table.order-information-table #order_status"); // stepKey: seeShipmentOrderStatus
		$I->comment("Entering Action Group [clearOrderFilters] AdminOrdersGridClearFiltersActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/sales/order/"); // stepKey: goToGridOrdersPageClearOrderFilters
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadClearOrderFilters
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header .admin__data-grid-filters-current._show", true); // stepKey: clickOnButtonToRemoveFiltersIfPresentClearOrderFilters
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitAfterClearFiltersClearOrderFilters
		$I->comment("Exiting Action Group [clearOrderFilters] AdminOrdersGridClearFiltersActionGroup");
	}
}
