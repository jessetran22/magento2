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
 * @Title("MAGETWO-92924: Verify credit memo grand total after shipping discount is applied via Cart Price Rule")
 * @Description("Verify credit memo grand total after shipping discount is applied via Cart Price Rule<h3>Test files</h3>app/code/Magento/Sales/Test/Mftf/Test/CreditMemoTotalAfterShippingDiscountTest.xml<br>")
 * @TestCaseId("MAGETWO-92924")
 * @group sales
 */
class CreditMemoTotalAfterShippingDiscountTestCest
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
		$I->createEntity("createProduct", "hook", "_defaultProduct", ["createCategory"], []); // stepKey: createProduct
		$I->comment("Entering Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdminWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin
		$I->comment("Exiting Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->comment("Entering Action Group [clearOrderFilters] AdminOrdersGridClearFiltersActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/sales/order/"); // stepKey: goToGridOrdersPageClearOrderFilters
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadClearOrderFilters
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header .admin__data-grid-filters-current._show", true); // stepKey: clickOnButtonToRemoveFiltersIfPresentClearOrderFilters
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitAfterClearFiltersClearOrderFilters
		$I->comment("Exiting Action Group [clearOrderFilters] AdminOrdersGridClearFiltersActionGroup");
		$I->comment("Entering Action Group [setShippingTaxClass] SetTaxClassForShippingActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_config/edit/section/tax/"); // stepKey: navigateToSalesTaxPageSetShippingTaxClass
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadSetShippingTaxClass
		$I->conditionalClick("#tax_classes-head", "#tax_classes-head:not(.open)", true); // stepKey: expandTaxClassesTabSetShippingTaxClass
		$I->waitForElementVisible("#tax_classes_shipping_tax_class", 30); // stepKey: seeShippingTaxClassSetShippingTaxClass
		$I->uncheckOption("#tax_classes_shipping_tax_class_inherit"); // stepKey: uncheckUseSystemValueSetShippingTaxClass
		$I->selectOption("#tax_classes_shipping_tax_class", "Taxable Goods"); // stepKey: setShippingTaxClassSetShippingTaxClass
		$I->click("#tax_classes-head"); // stepKey: collapseTaxClassesTabSetShippingTaxClass
		$I->click("#save"); // stepKey: saveConfigSetShippingTaxClass
		$I->waitForPageLoad(30); // stepKey: saveConfigSetShippingTaxClassWaitForPageLoad
		$I->comment("Exiting Action Group [setShippingTaxClass] SetTaxClassForShippingActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [resetTaxClassForShipping] ResetTaxClassForShippingActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_config/edit/section/tax/"); // stepKey: navigateToSalesTaxConfigPagetoResetResetTaxClassForShipping
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad2ResetTaxClassForShipping
		$I->conditionalClick("#tax_classes-head", "#tax_classes-head:not(.open)", true); // stepKey: openTaxClassTabResetTaxClassForShipping
		$I->waitForElementVisible("#tax_classes_shipping_tax_class", 30); // stepKey: seeShippingTaxClass2ResetTaxClassForShipping
		$I->selectOption("#tax_classes_shipping_tax_class", "None"); // stepKey: resetShippingTaxClassResetTaxClassForShipping
		$I->checkOption("#tax_classes_shipping_tax_class_inherit"); // stepKey: useSystemValueResetTaxClassForShipping
		$I->click("#tax_classes-head"); // stepKey: collapseTaxClassesTabResetTaxClassForShipping
		$I->click("#save"); // stepKey: saveConfigurationResetTaxClassForShipping
		$I->waitForPageLoad(30); // stepKey: saveConfigurationResetTaxClassForShippingWaitForPageLoad
		$I->comment("Exiting Action Group [resetTaxClassForShipping] ResetTaxClassForShippingActionGroup");
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
		$I->comment("Entering Action Group [clearOrderFilters] AdminOrdersGridClearFiltersActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/sales/order/"); // stepKey: goToGridOrdersPageClearOrderFilters
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadClearOrderFilters
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header .admin__data-grid-filters-current._show", true); // stepKey: clickOnButtonToRemoveFiltersIfPresentClearOrderFilters
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitAfterClearFiltersClearOrderFilters
		$I->comment("Exiting Action Group [clearOrderFilters] AdminOrdersGridClearFiltersActionGroup");
		$I->comment("Entering Action Group [adminLogout] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageAdminLogout
		$I->comment("Exiting Action Group [adminLogout] AdminLogoutActionGroup");
		$I->deleteEntity("createCategory", "hook"); // stepKey: deleteProduct1
		$I->deleteEntity("createProduct", "hook"); // stepKey: deleteCategory1
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
	 * @Features({"Sales"})
	 * @Stories({"Credit memos"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function CreditMemoTotalAfterShippingDiscountTest(AcceptanceTester $I)
	{
		$I->comment("Create a cart price rule for \$10 Fixed amount discount");
		$I->comment("Entering Action Group [amOnCartPriceList] AdminOpenCartPriceRulesPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/sales_rule/promo_quote/"); // stepKey: openCartPriceRulesPageAmOnCartPriceList
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAmOnCartPriceList
		$I->comment("Exiting Action Group [amOnCartPriceList] AdminOpenCartPriceRulesPageActionGroup");
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
		$I->comment("Open the Actions Tab in the Rules Edit page");
		$I->click("div[data-index='actions']"); // stepKey: clickToExpandActions
		$I->waitForPageLoad(30); // stepKey: clickToExpandActionsWaitForPageLoad
		$I->waitForElementVisible("input[name='apply_to_shipping']+label", 30); // stepKey: waitForElementToBeVisible
		$I->click("input[name='apply_to_shipping']+label"); // stepKey: enableApplyDiscountToShiping
		$I->seeCheckboxIsChecked("input[name='apply_to_shipping']"); // stepKey: discountIsAppliedToShiping
		$I->selectOption("select[name='simple_action']", "Fixed amount discount"); // stepKey: selectActionType
		$I->fillField("input[name='discount_amount']", "10"); // stepKey: fillDiscountAmount
		$I->click("#save"); // stepKey: clickSaveButton
		$I->waitForPageLoad(30); // stepKey: clickSaveButtonWaitForPageLoad
		$I->see("You saved the rule.", ".messages"); // stepKey: seeSuccessMessage
		$I->comment("Entering Action Group [adminLogout] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageAdminLogout
		$I->comment("Exiting Action Group [adminLogout] AdminLogoutActionGroup");
		$I->comment("Place an order from Storefront as a Guest");
		$I->amOnPage("/" . $I->retrieveEntityField('createCategory', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: onCategoryPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad1
		$I->comment("Adding the comment to replace action for preserving Backward Compatibility");
		$I->comment("Entering Action Group [hoverProduct] StorefrontHoverProductOnCategoryPageActionGroup");
		$I->moveMouseOver(".product-item-info"); // stepKey: hoverOverProductHoverProduct
		$I->comment("Exiting Action Group [hoverProduct] StorefrontHoverProductOnCategoryPageActionGroup");
		$I->comment("Entering Action Group [addToCart] StorefrontClickAddToCartButtonActionGroup");
		$I->click("button.action.tocart.primary"); // stepKey: addToCartAddToCart
		$I->waitForPageLoad(30); // stepKey: waitAddToCartAddToCart
		$I->comment("Exiting Action Group [addToCart] StorefrontClickAddToCartButtonActionGroup");
		$I->waitForElementVisible("div.message-success", 30); // stepKey: waitForProductToAdd
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
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad2
		$I->comment("fill out customer information");
		$I->fillField("#customer-email", msq("CustomerEntityOne") . "test@email.com"); // stepKey: enterEmail
		$I->fillField("input[name=firstname]", "John"); // stepKey: enterFirstName
		$I->fillField("input[name=lastname]", "Doe"); // stepKey: enterLastName
		$I->fillField("input[name='street[0]']", "7700 W Parmer Ln"); // stepKey: enterStreet
		$I->fillField("input[name=city]", "Austin"); // stepKey: enterCity
		$I->selectOption("select[name=region_id]", "Texas"); // stepKey: selectRegion
		$I->fillField("input[name=postcode]", "78729"); // stepKey: enterPostcode
		$I->fillField("input[name=telephone]", "1234568910"); // stepKey: enterTelephone
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMask
		$I->comment("Choose Shippping - Flat Rate Shipping");
		$I->click("//*[@id='checkout-shipping-method-load']//input[@class='radio']"); // stepKey: selectFirstShippingMethod
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMask2
		$I->comment("Entering Action Group [clickNext] StorefrontCheckoutClickNextButtonActionGroup");
		$I->waitForElementVisible("button.button.action.continue.primary", 30); // stepKey: waitForNextButtonClickNext
		$I->waitForPageLoad(30); // stepKey: waitForNextButtonClickNextWaitForPageLoad
		$I->click("button.button.action.continue.primary"); // stepKey: clickOnNextButtonClickNext
		$I->waitForPageLoad(30); // stepKey: clickOnNextButtonClickNextWaitForPageLoad
		$I->comment("Exiting Action Group [clickNext] StorefrontCheckoutClickNextButtonActionGroup");
		$I->comment("Checkout select Check/Money Order payment");
		$I->comment("Entering Action Group [selectCheckMoneyPayment3] CheckoutSelectCheckMoneyOrderPaymentActionGroup");
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskSelectCheckMoneyPayment3
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadSelectCheckMoneyPayment3
		$I->conditionalClick("//div[@id='checkout-payment-method-load']//div[@class='payment-method']//label//span[contains(., 'Check / Money order')]/../..//input", "//div[@id='checkout-payment-method-load']//div[@class='payment-method']//label//span[contains(., 'Check / Money order')]/../..//input", true); // stepKey: selectCheckmoPaymentMethodSelectCheckMoneyPayment3
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskAfterPaymentMethodSelectionSelectCheckMoneyPayment3
		$I->comment("Exiting Action Group [selectCheckMoneyPayment3] CheckoutSelectCheckMoneyOrderPaymentActionGroup");
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
		$I->comment("Entering Action Group [loginAsAdmin1] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin1
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin1
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin1
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin1
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdmin1WaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin1
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin1
		$I->comment("Exiting Action Group [loginAsAdmin1] AdminLoginActionGroup");
		$I->comment("Search for Order in the order grid");
		$I->comment("Entering Action Group [onOrdersPage] AdminOrdersPageOpenActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/sales/order/"); // stepKey: openOrdersGridPageOnOrdersPage
		$I->waitForPageLoad(30); // stepKey: waitForLoadingPageOnOrdersPage
		$I->comment("Exiting Action Group [onOrdersPage] AdminOrdersPageOpenActionGroup");
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clearExistingOrderFilter
		$I->waitForPageLoad(30); // stepKey: clearExistingOrderFilterWaitForPageLoad
		$I->fillField("#fulltext", $grabOrderNumber); // stepKey: searchOrderNum
		$I->click(".//*[@id='container']/div/div[2]/div[1]/div[2]/button"); // stepKey: submitSearch
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMask4
		$I->comment("Create invoice");
		$I->comment("Entering Action Group [clickOrderRow] AdminOrderGridClickFirstRowActionGroup");
		$I->click("tr.data-row:nth-of-type(1)"); // stepKey: clickFirstOrderRowClickOrderRow
		$I->waitForPageLoad(30); // stepKey: waitForOrderPageLoadClickOrderRow
		$I->comment("Exiting Action Group [clickOrderRow] AdminOrderGridClickFirstRowActionGroup");
		$I->comment("Entering Action Group [clickInvoiceButton] AdminClickInvoiceButtonOrderViewActionGroup");
		$I->click("#order_invoice"); // stepKey: clickInvoiceActionClickInvoiceButton
		$I->waitForPageLoad(30); // stepKey: clickInvoiceActionClickInvoiceButtonWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForProductPageClickInvoiceButton
		$I->comment("Exiting Action Group [clickInvoiceButton] AdminClickInvoiceButtonOrderViewActionGroup");
		$I->see("New Invoice", ".page-header h1.page-title"); // stepKey: seeNewInvoiceInPageTitle
		$I->comment("Verify Invoice Totals including subTotal Shipping  Discount and GrandTotal");
		$I->see("$123.00", "//table[contains(@class,'order-subtotal-table')]/tbody/tr/td[contains(text(), 'Subtotal')]/following-sibling::td/span/span[contains(@class, 'price')]"); // stepKey: seeInvoiceSubTotal
		$I->comment("Shipping and Handling");
		$I->see("$5.00", "//table[contains(@class,'order-subtotal-table')]/tbody/tr/td[contains(text(), 'Shipping')]/following-sibling::td/span/span[contains(@class, 'price')]"); // stepKey: seeShippingAndHandling
		$I->scrollTo("//table[contains(@class,'order-subtotal-table')]/tbody/tr/td[contains(text(), 'Shipping')]/following-sibling::td/span/span[contains(@class, 'price')]"); // stepKey: scrollToInvoiceTotals
		$grabShippingCost = $I->grabTextFrom("//table[contains(@class,'order-subtotal-table')]/tbody/tr/td[contains(text(), 'Shipping')]/following-sibling::td/span/span[contains(@class, 'price')]"); // stepKey: grabShippingCost
		$I->assertEquals("$5.00", ($grabShippingCost), "ExpectedShipping"); // stepKey: assertShippingAndHandling
		$I->see("-$15.00", "//table[contains(@class,'order-subtotal-table')]/tbody/tr/td[contains(text(), 'Discount')]/following-sibling::td/span/span[contains(@class, 'price')]"); // stepKey: seeShippingAndHandling2
		$grabInvoiceDiscount = $I->grabTextFrom("//table[contains(@class,'order-subtotal-table')]/tbody/tr/td[contains(text(), 'Discount')]/following-sibling::td/span/span[contains(@class, 'price')]"); // stepKey: grabInvoiceDiscount
		$I->assertEquals("-$15.00", ($grabInvoiceDiscount), "ExpectedDiscount"); // stepKey: assertDiscountValue
		$I->see("$113.00", ".order-subtotal-table tfoot tr.col-0>td span.price"); // stepKey: seeCorrectGrandTotal
		$grabInvoiceGrandTotal = $I->grabTextFrom(".order-subtotal-table tfoot tr.col-0>td span.price"); // stepKey: grabInvoiceGrandTotal
		$I->comment("Entering Action Group [clickSubmitInvoice] AdminInvoiceClickSubmitActionGroup");
		$I->click(".action-default.scalable.save.submit-button.primary"); // stepKey: clickSubmitInvoiceClickSubmitInvoice
		$I->waitForPageLoad(60); // stepKey: clickSubmitInvoiceClickSubmitInvoiceWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForInvoiceToBeCreatedClickSubmitInvoice
		$I->comment("Exiting Action Group [clickSubmitInvoice] AdminInvoiceClickSubmitActionGroup");
		$I->see("The invoice has been created.", "div.message-success"); // stepKey: seeSuccessMessage1
		$I->see("Processing", ".order-information table.order-information-table #order_status"); // stepKey: seeOrderProcessing
		$I->comment("Create Credit Memo");
		$I->comment("Admin creates credit memo");
		$I->click("#order_creditmemo"); // stepKey: clickCreateCreditMemo
		$I->waitForPageLoad(30); // stepKey: clickCreateCreditMemoWaitForPageLoad
		$I->seeInCurrentUrl((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/sales/order_creditmemo/new/order_id/"); // stepKey: seeNewCreditMemoPage
		$I->see("New Memo", ".page-header h1.page-title"); // stepKey: seeNewMemoInPageTitle
		$I->comment("Verify Refund Totals");
		$I->see("$123.00", "//table[contains(@class,'order-subtotal-table')]/tbody/tr/td[contains(text(), 'Subtotal')]/following-sibling::td//span[contains(@class, 'price')]"); // stepKey: seeRefundSubTotal
		$grabRefundDiscountValue = $I->grabTextFrom("//table[contains(@class,'order-subtotal-table')]/tbody/tr/td[contains(text(), 'Discount')]/following-sibling::td//span[contains(@class, 'price')]"); // stepKey: grabRefundDiscountValue
		$I->assertEquals("-$15.00", ($grabRefundDiscountValue), "notExpectedDiscountOnRefundPage"); // stepKey: assertDiscountValue1
		$grabRefundGrandTotal = $I->grabTextFrom(".order-subtotal-table tfoot tr.col-0>td span.price"); // stepKey: grabRefundGrandTotal
		$I->assertEquals(($grabInvoiceGrandTotal), ($grabRefundGrandTotal), "RefundGrandTotalMatchesWithInvoiceGrandTotal"); // stepKey: compareRefundGrandTotalAndInvoiceGrandTotal
	}
}
