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
 * @Title("MC-42650: Tax for quote with virtual products only should be calculated based on customer default billing address")
 * @Description("Tax for quote with virtual products only should be calculated based on customer default billing address<h3>Test files</h3>app/code/Magento/Tax/Test/Mftf/Test/StorefrontCustomerWithDefaultBillingAddressAndCartWithVirtualProductTaxTest.xml<br>")
 * @TestCaseId("MC-42650")
 * @group Tax
 */
class StorefrontCustomerWithDefaultBillingAddressAndCartWithVirtualProductTaxTestCest
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
		$I->comment("Fill in rules to display tax in the cart");
		$I->comment("Entering Action Group [fillDefaultTaxForms] EditTaxConfigurationByUIActionGroup");
		$I->comment("navigate to the tax configuration page");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_config/edit/section/tax/"); // stepKey: goToAdminTaxPageFillDefaultTaxForms
		$I->waitForPageLoad(30); // stepKey: waitForTaxConfigLoadFillDefaultTaxForms
		$I->comment("change the default state to California");
		$I->scrollTo("#tax_defaults-head", 0, -80); // stepKey: scrollToTaxDefaultsFillDefaultTaxForms
		$I->comment("conditionalClick twice to fix some flaky behavior");
		$I->conditionalClick("#tax_defaults-head", "#tax_defaults", false); // stepKey: clickCalculationSettingsFillDefaultTaxForms
		$I->waitForPageLoad(30); // stepKey: clickCalculationSettingsFillDefaultTaxFormsWaitForPageLoad
		$I->conditionalClick("#tax_defaults-head", "#tax_defaults", false); // stepKey: clickCalculationSettingsAgainFillDefaultTaxForms
		$I->waitForPageLoad(30); // stepKey: clickCalculationSettingsAgainFillDefaultTaxFormsWaitForPageLoad
		$I->uncheckOption("#row_tax_defaults_region input[type='checkbox']"); // stepKey: clickDefaultStateFillDefaultTaxForms
		$I->selectOption("#row_tax_defaults_region select", "California"); // stepKey: selectDefaultStateFillDefaultTaxForms
		$I->fillField("#tax_defaults_postcode", "*"); // stepKey: fillDefaultPostCodeFillDefaultTaxForms
		$I->comment("change the options for shopping cart display to show tax");
		$I->scrollTo("#tax_cart_display-head", 0, -80); // stepKey: scrollToTaxShoppingCartDisplayFillDefaultTaxForms
		$I->comment("conditionalClick twice to fix some flaky behavior");
		$I->conditionalClick("#tax_cart_display-head", "#tax_cart_display", false); // stepKey: clickShoppingCartDisplaySettingsFillDefaultTaxForms
		$I->waitForPageLoad(30); // stepKey: clickShoppingCartDisplaySettingsFillDefaultTaxFormsWaitForPageLoad
		$I->conditionalClick("#tax_cart_display-head", "#tax_cart_display", false); // stepKey: clickShoppingCartDisplaySettingsAgainFillDefaultTaxForms
		$I->waitForPageLoad(30); // stepKey: clickShoppingCartDisplaySettingsAgainFillDefaultTaxFormsWaitForPageLoad
		$I->uncheckOption("#row_tax_cart_display_grandtotal input[type='checkbox']"); // stepKey: clickTaxTotalCartFillDefaultTaxForms
		$I->selectOption("#row_tax_cart_display_grandtotal select", "Yes"); // stepKey: selectTaxTotalCartFillDefaultTaxForms
		$I->uncheckOption("#row_tax_cart_display_full_summary input[type='checkbox']"); // stepKey: clickDisplayTaxSummaryCartFillDefaultTaxForms
		$I->selectOption("#row_tax_cart_display_full_summary select", "Yes"); // stepKey: selectDisplayTaxSummaryCartFillDefaultTaxForms
		$I->uncheckOption("#row_tax_cart_display_zero_tax input[type='checkbox']"); // stepKey: clickDisplayZeroTaxCartFillDefaultTaxForms
		$I->selectOption("#row_tax_cart_display_zero_tax select", "Yes"); // stepKey: selectDisplayZeroTaxCartFillDefaultTaxForms
		$I->comment("change the options for orders, invoices, credit memos display to show tax");
		$I->scrollTo("#tax_sales_display-head", 0, -80); // stepKey: scrollToTaxSalesDisplayFillDefaultTaxForms
		$I->comment("conditionalClick twice to fix some flaky behavior");
		$I->conditionalClick("#tax_sales_display-head", "#tax_sales_display", false); // stepKey: clickOrdersInvoicesCreditSalesFillDefaultTaxForms
		$I->waitForPageLoad(30); // stepKey: clickOrdersInvoicesCreditSalesFillDefaultTaxFormsWaitForPageLoad
		$I->conditionalClick("#tax_sales_display-head", "#tax_sales_display", false); // stepKey: clickOrdersInvoicesCreditSalesAgainFillDefaultTaxForms
		$I->waitForPageLoad(30); // stepKey: clickOrdersInvoicesCreditSalesAgainFillDefaultTaxFormsWaitForPageLoad
		$I->uncheckOption("#row_tax_sales_display_grandtotal input[type='checkbox']"); // stepKey: clickTaxTotalSalesFillDefaultTaxForms
		$I->selectOption("#row_tax_sales_display_grandtotal select", "Yes"); // stepKey: selectTaxTotalSalesFillDefaultTaxForms
		$I->uncheckOption("#row_tax_sales_display_full_summary input[type='checkbox']"); // stepKey: clickDisplayTaxSummarySalesFillDefaultTaxForms
		$I->selectOption("#row_tax_sales_display_full_summary select", "Yes"); // stepKey: selectDisplayTaxSummarySalesFillDefaultTaxForms
		$I->uncheckOption("#row_tax_sales_display_zero_tax input[type='checkbox']"); // stepKey: clickDisplayZeroTaxSalesFillDefaultTaxForms
		$I->selectOption("#row_tax_sales_display_zero_tax select", "Yes"); // stepKey: selectDisplayZeroTaxSalesFillDefaultTaxForms
		$I->comment("Save the settings");
		$I->scrollToTopOfPage(); // stepKey: scrollToTopFillDefaultTaxForms
		$I->click(".page-actions-inner #save"); // stepKey: saveTaxOptionsFillDefaultTaxForms
		$I->waitForPageLoad(30); // stepKey: saveTaxOptionsFillDefaultTaxFormsWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForTaxSavedFillDefaultTaxForms
		$I->see("You saved the configuration.", ".message-success"); // stepKey: seeSuccessFillDefaultTaxForms
		$I->comment("Exiting Action Group [fillDefaultTaxForms] EditTaxConfigurationByUIActionGroup");
		$I->comment("Create tax rate for TX");
		$I->createEntity("createTaxRateTX", "hook", "TaxRateTexas", [], []); // stepKey: createTaxRateTX
		$I->comment("Create tax rule");
		$I->comment("Entering Action Group [createTaxRule] AdminCreateTaxRuleWithTwoTaxRatesActionGroup");
		$I->comment("Create Tax Rule");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/tax/rule"); // stepKey: goToTaxRulePageCreateTaxRule
		$I->waitForPageLoad(30); // stepKey: waitForTaxRatePageCreateTaxRule
		$I->click("#add"); // stepKey: addNewTaxRateCreateTaxRule
		$I->waitForPageLoad(30); // stepKey: addNewTaxRateCreateTaxRuleWaitForPageLoad
		$I->fillField("#anchor-content #code", "TaxRule" . msq("SimpleTaxRule")); // stepKey: fillRuleNameCreateTaxRule
		$I->click("//span[text()='" . $I->retrieveEntityField('createTaxRateTX', 'code', 'hook') . "']"); // stepKey: selectTaxRateCreateTaxRule
		$I->click("//span[text()='US-NY-*-Rate 1']"); // stepKey: selectTaxRate2CreateTaxRule
		$I->click("#details-summarybase_fieldset"); // stepKey: clickAdditionalSettingsCreateTaxRule
		$I->waitForPageLoad(30); // stepKey: clickAdditionalSettingsCreateTaxRuleWaitForPageLoad
		$I->fillField("#priority", "0"); // stepKey: fillPriorityCreateTaxRule
		$I->fillField("#position", "0"); // stepKey: fillPositionCreateTaxRule
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingCreateTaxRule
		$I->click("#save"); // stepKey: clickSaveCreateTaxRule
		$I->waitForPageLoad(90); // stepKey: clickSaveCreateTaxRuleWaitForPageLoad
		$I->comment("Exiting Action Group [createTaxRule] AdminCreateTaxRuleWithTwoTaxRatesActionGroup");
		$I->comment("Create a virtual product");
		$I->createEntity("createVirtualProduct", "hook", "VirtualProduct", [], []); // stepKey: createVirtualProduct
		$I->comment("Create customer");
		$I->createEntity("createCustomer", "hook", "Simple_US_Customer_With_Different_Billing_Shipping_Addresses", [], []); // stepKey: createCustomer
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Ensure tax won't be shown in the cart");
		$I->comment("Entering Action Group [changeToDefaultTaxConfiguration] ChangeToDefaultTaxConfigurationUIActionGroup");
		$I->comment("navigate to the tax configuration page");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_config/edit/section/tax/"); // stepKey: goToAdminTaxPageChangeToDefaultTaxConfiguration
		$I->waitForPageLoad(30); // stepKey: waitForTaxConfigLoadChangeToDefaultTaxConfiguration
		$I->comment("change the default state to none");
		$I->comment("conditionalClick twice to fix some flaky behavior");
		$I->conditionalClick("#tax_defaults-head", "#row_tax_defaults_region input[type='checkbox']", false); // stepKey: clickCalculationSettingsChangeToDefaultTaxConfiguration
		$I->conditionalClick("#tax_defaults-head", "#row_tax_defaults_region input[type='checkbox']", false); // stepKey: clickCalculationSettingsAgainChangeToDefaultTaxConfiguration
		$I->checkOption("#row_tax_defaults_region input[type='checkbox']"); // stepKey: clickDefaultStateChangeToDefaultTaxConfiguration
		$I->selectOption("#row_tax_defaults_region select", "California"); // stepKey: selectDefaultStateChangeToDefaultTaxConfiguration
		$I->fillField("#tax_defaults_postcode", ""); // stepKey: fillDefaultPostCodeChangeToDefaultTaxConfiguration
		$I->comment("change the options for shopping cart display to not show tax");
		$I->comment("conditionalClick twice to fix some flaky behavior");
		$I->conditionalClick("#tax_cart_display-head", "#row_tax_cart_display_grandtotal input[type='checkbox']", false); // stepKey: clickShoppingCartDisplaySettingsChangeToDefaultTaxConfiguration
		$I->conditionalClick("#tax_cart_display-head", "#row_tax_cart_display_grandtotal input[type='checkbox']", false); // stepKey: clickShoppingCartDisplaySettingsAgainChangeToDefaultTaxConfiguration
		$I->checkOption("#row_tax_cart_display_grandtotal input[type='checkbox']"); // stepKey: clickTaxTotalCartChangeToDefaultTaxConfiguration
		$I->selectOption("#row_tax_cart_display_grandtotal select", "Yes"); // stepKey: selectTaxTotalCartChangeToDefaultTaxConfiguration
		$I->checkOption("#row_tax_cart_display_full_summary input[type='checkbox']"); // stepKey: clickDisplayTaxSummaryCartChangeToDefaultTaxConfiguration
		$I->selectOption("#row_tax_cart_display_full_summary select", "Yes"); // stepKey: selectDisplayTaxSummaryCartChangeToDefaultTaxConfiguration
		$I->checkOption("#row_tax_cart_display_zero_tax input[type='checkbox']"); // stepKey: clickDisplayZeroTaxCartChangeToDefaultTaxConfiguration
		$I->selectOption("#row_tax_cart_display_zero_tax select", "Yes"); // stepKey: selectDisplayZeroTaxCartChangeToDefaultTaxConfiguration
		$I->comment("change the options for orders, invoices, credit memos display to not show tax");
		$I->comment("conditionalClick twice to fix some flaky behavior");
		$I->conditionalClick("#tax_sales_display-head", "#row_tax_sales_display_grandtotal input[type='checkbox']", false); // stepKey: clickOrdersInvoicesCreditSalesChangeToDefaultTaxConfiguration
		$I->conditionalClick("#tax_sales_display-head", "#row_tax_sales_display_grandtotal input[type='checkbox']", false); // stepKey: clickOrdersInvoicesCreditSalesAgainChangeToDefaultTaxConfiguration
		$I->checkOption("#row_tax_sales_display_grandtotal input[type='checkbox']"); // stepKey: clickTaxTotalSalesChangeToDefaultTaxConfiguration
		$I->selectOption("#row_tax_sales_display_grandtotal select", "Yes"); // stepKey: selectTaxTotalSalesChangeToDefaultTaxConfiguration
		$I->checkOption("#row_tax_sales_display_full_summary input[type='checkbox']"); // stepKey: clickDisplayTaxSummarySalesChangeToDefaultTaxConfiguration
		$I->selectOption("#row_tax_sales_display_full_summary select", "Yes"); // stepKey: selectDisplayTaxSummarySalesChangeToDefaultTaxConfiguration
		$I->checkOption("#row_tax_sales_display_zero_tax input[type='checkbox']"); // stepKey: clickDisplayZeroTaxSalesChangeToDefaultTaxConfiguration
		$I->selectOption("#row_tax_sales_display_zero_tax select", "Yes"); // stepKey: selectDisplayZeroTaxSalesChangeToDefaultTaxConfiguration
		$I->comment("Save the settings");
		$I->scrollToTopOfPage(); // stepKey: scrollToTopChangeToDefaultTaxConfiguration
		$I->click(".page-actions-inner #save"); // stepKey: saveTaxOptionsChangeToDefaultTaxConfiguration
		$I->waitForPageLoad(30); // stepKey: saveTaxOptionsChangeToDefaultTaxConfigurationWaitForPageLoad
		$I->see("You saved the configuration.", ".message-success"); // stepKey: seeSuccessChangeToDefaultTaxConfiguration
		$I->comment("Exiting Action Group [changeToDefaultTaxConfiguration] ChangeToDefaultTaxConfigurationUIActionGroup");
		$I->comment("Delete tax rule");
		$I->comment("Entering Action Group [deleteTaxRule] AdminDeleteTaxRule");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/tax/rule"); // stepKey: goToTaxRuleGridPageDeleteTaxRule
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad1DeleteTaxRule
		$I->click(".admin__data-grid-header [data-action='grid-filter-reset']"); // stepKey: clickClearFiltersDeleteTaxRule
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersDeleteTaxRuleWaitForPageLoad
		$I->fillField("#taxRuleGrid_filter_code", "TaxRule" . msq("SimpleTaxRule")); // stepKey: fillTaxRuleCodeDeleteTaxRule
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickSearchDeleteTaxRule
		$I->waitForPageLoad(30); // stepKey: clickSearchDeleteTaxRuleWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForTaxRuleSearchDeleteTaxRule
		$I->click("tr[data-role='row']:nth-of-type(1)"); // stepKey: clickFirstRowDeleteTaxRule
		$I->waitForPageLoad(30); // stepKey: clickFirstRowDeleteTaxRuleWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadDeleteTaxRule
		$I->click("#delete"); // stepKey: clickDeleteRuleDeleteTaxRule
		$I->waitForPageLoad(30); // stepKey: clickDeleteRuleDeleteTaxRuleWaitForPageLoad
		$I->click("button.action-primary.action-accept"); // stepKey: clickOkDeleteTaxRule
		$I->waitForPageLoad(30); // stepKey: clickOkDeleteTaxRuleWaitForPageLoad
		$I->comment("Exiting Action Group [deleteTaxRule] AdminDeleteTaxRule");
		$I->comment("Delete tax rate for UK");
		$I->deleteEntity("createTaxRateTX", "hook"); // stepKey: deleteTaxRateUK
		$I->comment("Delete virtual product");
		$I->deleteEntity("createVirtualProduct", "hook"); // stepKey: deleteVirtualProduct
		$I->comment("Delete customer");
		$I->deleteEntity("createCustomer", "hook"); // stepKey: deleteCustomer
		$I->comment("Logout from admin");
		$I->comment("Entering Action Group [amOnLogoutPage] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageAmOnLogoutPage
		$I->comment("Exiting Action Group [amOnLogoutPage] AdminLogoutActionGroup");
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
	 * @Features({"Tax"})
	 * @Stories({"Tax Calculation in Shopping Cart"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StorefrontCustomerWithDefaultBillingAddressAndCartWithVirtualProductTaxTest(AcceptanceTester $I)
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
		$I->comment("Navigate to the product");
		$I->comment("Entering Action Group [openProduct2Page] StorefrontOpenProductEntityPageActionGroup");
		$I->amOnPage("/" . $I->retrieveEntityField('createVirtualProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: goToProductPageOpenProduct2Page
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoadedOpenProduct2Page
		$I->comment("Exiting Action Group [openProduct2Page] StorefrontOpenProductEntityPageActionGroup");
		$I->comment("Add to cart");
		$I->comment("Entering Action Group [product2AddToCart] StorefrontAddToTheCartActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadProduct2AddToCart
		$I->scrollTo("#product-addtocart-button"); // stepKey: scrollToAddToCartButtonProduct2AddToCart
		$I->waitForPageLoad(60); // stepKey: scrollToAddToCartButtonProduct2AddToCartWaitForPageLoad
		$I->click("#product-addtocart-button"); // stepKey: addToCartProduct2AddToCart
		$I->waitForPageLoad(60); // stepKey: addToCartProduct2AddToCartWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadProduct2AddToCart
		$I->waitForElementVisible("div.message-success.success.message", 30); // stepKey: waitForSuccessMessageProduct2AddToCart
		$I->comment("Exiting Action Group [product2AddToCart] StorefrontAddToTheCartActionGroup");
		$I->comment("Click on mini cart");
		$I->comment("Entering Action Group [clickOnMiniCart] StorefrontClickOnMiniCartActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollToTheTopOfThePageClickOnMiniCart
		$I->waitForElementVisible("a.showcart", 30); // stepKey: waitForElementToBeVisibleClickOnMiniCart
		$I->waitForPageLoad(60); // stepKey: waitForElementToBeVisibleClickOnMiniCartWaitForPageLoad
		$I->click("a.showcart"); // stepKey: clickOnMiniCartClickOnMiniCart
		$I->waitForPageLoad(60); // stepKey: clickOnMiniCartClickOnMiniCartWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadClickOnMiniCart
		$I->comment("Exiting Action Group [clickOnMiniCart] StorefrontClickOnMiniCartActionGroup");
		$I->comment("Click on view and edit cart link");
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
		$I->waitForPageLoad(30); // stepKey: waitForViewAndEditCartToOpen
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMask
		$I->waitForElementVisible("[data-th='Tax'] span", 30); // stepKey: waitForOverviewVisible1
		$I->waitForPageLoad(30); // stepKey: waitForOverviewVisible1WaitForPageLoad
		$I->comment("Verify tax in shopping cart");
		$I->see("$7.25", "[data-th='Tax'] span"); // stepKey: verifyTaxInShoppingCartPage
		$I->waitForPageLoad(30); // stepKey: verifyTaxInShoppingCartPageWaitForPageLoad
		$I->comment("Navigate to payment page");
		$I->comment("Entering Action Group [goToCheckout] StorefrontOpenCheckoutPageActionGroup");
		$I->amOnPage("/checkout"); // stepKey: openCheckoutPageGoToCheckout
		$I->waitForPageLoad(30); // stepKey: waitForCheckoutPageLoadedGoToCheckout
		$I->comment("Exiting Action Group [goToCheckout] StorefrontOpenCheckoutPageActionGroup");
		$I->waitForElementVisible("[data-th='Tax'] span", 30); // stepKey: waitForOverviewVisible2
		$I->waitForPageLoad(30); // stepKey: waitForOverviewVisible2WaitForPageLoad
		$I->comment("Verify tax on payment page");
		$I->see("$7.25", "[data-th='Tax'] span"); // stepKey: verifyTaxOnPaymentPage
		$I->waitForPageLoad(30); // stepKey: verifyTaxOnPaymentPageWaitForPageLoad
		$I->comment("Place order");
		$I->comment("Entering Action Group [clickPlacePurchaseOrder] ClickPlaceOrderActionGroup");
		$I->waitForElement(".payment-method._active button.action.primary.checkout", 30); // stepKey: waitForPlaceOrderButtonClickPlacePurchaseOrder
		$I->waitForPageLoad(30); // stepKey: waitForPlaceOrderButtonClickPlacePurchaseOrderWaitForPageLoad
		$I->click(".payment-method._active button.action.primary.checkout"); // stepKey: clickPlaceOrderClickPlacePurchaseOrder
		$I->waitForPageLoad(30); // stepKey: clickPlaceOrderClickPlacePurchaseOrderWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCheckoutClickPlacePurchaseOrder
		$I->see("Thank you for your purchase!", ".page-title"); // stepKey: waitForLoadSuccessPageClickPlacePurchaseOrder
		$I->comment("Exiting Action Group [clickPlacePurchaseOrder] ClickPlaceOrderActionGroup");
		$I->comment("Navigate to order details page");
		$grabOrderNumber = $I->grabTextFrom(".order-number>strong"); // stepKey: grabOrderNumber
		$I->comment("Entering Action Group [openOrderFromSuccessPage] StorefrontOpenOrderFromSuccessPageActionGroup");
		$I->click("//div[contains(@class,'success')]//a[contains(.,'{$grabOrderNumber}')]"); // stepKey: clickOrderNumberLinkOpenOrderFromSuccessPage
		$I->waitForPageLoad(30); // stepKey: clickOrderNumberLinkOpenOrderFromSuccessPageWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForOrderPageIsLoadedOpenOrderFromSuccessPage
		$I->see("Order # {$grabOrderNumber}", ".page-title span"); // stepKey: assertOrderNumberIsCorrectOpenOrderFromSuccessPage
		$I->comment("Exiting Action Group [openOrderFromSuccessPage] StorefrontOpenOrderFromSuccessPageActionGroup");
		$I->comment("Verify tax on order view page");
		$I->see("$7.25", ".totals-tax-summary .amount .price"); // stepKey: verifyTaxOnOrderViewPage
		$I->waitForPageLoad(30); // stepKey: verifyTaxOnOrderViewPageWaitForPageLoad
	}
}
