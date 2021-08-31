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
 * @Title("MC-39777: Incorrect Quantity Shipped Displayed on order detail page on the front")
 * @Description("Verify shipment quantity for decimal quantity at frontend order shipment tab<h3>Test files</h3>app/code/Magento/Sales/Test/Mftf/Test/StorefrontVerifyOrderShipmentForDecimalQuantityTest.xml<br>")
 * @TestCaseId("MC-39777")
 * @group Sales
 */
class StorefrontVerifyOrderShipmentForDecimalQuantityTestCest
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
		$I->createEntity("createSimpleCategory", "hook", "_defaultCategory", [], []); // stepKey: createSimpleCategory
		$I->createEntity("createSimpleProduct", "hook", "SimpleProduct", ["createSimpleCategory"], []); // stepKey: createSimpleProduct
		$createSimpleUsCustomerFields['group_id'] = "1";
		$I->createEntity("createSimpleUsCustomer", "hook", "Simple_US_Customer", [], $createSimpleUsCustomerFields); // stepKey: createSimpleUsCustomer
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Clear Filters");
		$I->comment("Entering Action Group [ClearFiltersAfter] AdminClearFiltersActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/"); // stepKey: GoToCatalogProductPageClearFiltersAfter
		$I->waitForPageLoad(30); // stepKey: WaitForPageToLoadClearFiltersAfter
		$I->conditionalClick("//div[@class='admin__data-grid-header']//button[@data-action='grid-filter-reset']", "//div[@class='admin__data-grid-header']//button[@data-action='grid-filter-reset']", true); // stepKey: ClickOnButtonToRemoveFiltersIfPresentClearFiltersAfter
		$I->waitForPageLoad(30); // stepKey: ClickOnButtonToRemoveFiltersIfPresentClearFiltersAfterWaitForPageLoad
		$I->comment("Exiting Action Group [ClearFiltersAfter] AdminClearFiltersActionGroup");
		$I->comment("Entering Action Group [clearOrderListingFilters] AdminOrdersGridClearFiltersActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/sales/order/"); // stepKey: goToGridOrdersPageClearOrderListingFilters
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadClearOrderListingFilters
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header .admin__data-grid-filters-current._show", true); // stepKey: clickOnButtonToRemoveFiltersIfPresentClearOrderListingFilters
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitAfterClearFiltersClearOrderListingFilters
		$I->comment("Exiting Action Group [clearOrderListingFilters] AdminOrdersGridClearFiltersActionGroup");
		$I->deleteEntity("createSimpleCategory", "hook"); // stepKey: deletePreReqCategory
		$I->deleteEntity("createSimpleProduct", "hook"); // stepKey: deletePreReqSimpleProduct
		$I->comment("Logout from customer account");
		$I->amOnPage("customer/account/logout/"); // stepKey: logoutCustomerOne
		$I->waitForPageLoad(30); // stepKey: waitLogoutCustomerOne
		$I->deleteEntity("createSimpleUsCustomer", "hook"); // stepKey: deleteCustomer
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
	 * @Stories({"Verify shipment quantity for decimal quantity at frontend order shipment tab"})
	 * @Features({"Sales"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StorefrontVerifyOrderShipmentForDecimalQuantityTest(AcceptanceTester $I)
	{
		$I->comment("Step1. Login as admin. Go to Catalog > Products page. Filtering *prod1*. Open *prod1* to edit");
		$I->comment("Entering Action Group [LoginAsAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdminWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin
		$I->comment("Exiting Action Group [LoginAsAdmin] AdminLoginActionGroup");
		$I->comment("Entering Action Group [filterGroupedProductOptions] SearchForProductOnBackendActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: navigateToProductIndexFilterGroupedProductOptions
		$I->waitForPageLoad(60); // stepKey: waitForProductsPageToLoadFilterGroupedProductOptions
		$I->click("#container > div > div.admin__data-grid-header > div:nth-child(1) > div.data-grid-filters-actions-wrap > div > button"); // stepKey: openFiltersSectionOnProductsPageFilterGroupedProductOptions
		$I->conditionalClick("//div[@class='admin__data-grid-header']//button[@class='action-tertiary action-clear']", "//div[@class='admin__data-grid-header']//button[@class='action-tertiary action-clear']", true); // stepKey: cleanFiltersIfTheySetFilterGroupedProductOptions
		$I->waitForPageLoad(10); // stepKey: cleanFiltersIfTheySetFilterGroupedProductOptionsWaitForPageLoad
		$I->fillField("input[name=sku]", $I->retrieveEntityField('createSimpleProduct', 'sku', 'test')); // stepKey: fillSkuFieldOnFiltersSectionFilterGroupedProductOptions
		$I->click("button[data-action=grid-filter-apply]"); // stepKey: clickApplyFiltersButtonFilterGroupedProductOptions
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersButtonFilterGroupedProductOptionsWaitForPageLoad
		$I->comment("Exiting Action Group [filterGroupedProductOptions] SearchForProductOnBackendActionGroup");
		$I->comment("Step2. Update product Advanced Inventory Setting.
        Set *Qty Uses Decimals* to *Yes* and *Enable Qty Increments* to *Yes* and *Qty Increments* to *2.14*.");
		$I->comment("Entering Action Group [openProduct] OpenProductForEditByClickingRowXColumnYInProductGridActionGroup");
		$I->click("table.data-grid tr.data-row:nth-child(1) td:nth-child(2)"); // stepKey: openProductForEditOpenProduct
		$I->waitForPageLoad(30); // stepKey: openProductForEditOpenProductWaitForPageLoad
		$I->comment("Exiting Action Group [openProduct] OpenProductForEditByClickingRowXColumnYInProductGridActionGroup");
		$I->comment("Entering Action Group [clickOnAdvancedInventoryLink] AdminClickOnAdvancedInventoryLinkActionGroup");
		$I->click("button[data-index='advanced_inventory_button'].action-additional"); // stepKey: clickOnAdvancedInventoryLinkClickOnAdvancedInventoryLink
		$I->waitForPageLoad(30); // stepKey: clickOnAdvancedInventoryLinkClickOnAdvancedInventoryLinkWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForAdvancedInventoryPageToLoadClickOnAdvancedInventoryLink
		$I->comment("Wait for close button appeared. That means animation finished and modal window is fully visible");
		$I->waitForElementVisible(".product_form_product_form_advanced_inventory_modal button.action-close", 30); // stepKey: waitForCloseButtonAppearedClickOnAdvancedInventoryLink
		$I->waitForPageLoad(30); // stepKey: waitForCloseButtonAppearedClickOnAdvancedInventoryLinkWaitForPageLoad
		$I->comment("Exiting Action Group [clickOnAdvancedInventoryLink] AdminClickOnAdvancedInventoryLinkActionGroup");
		$I->comment("Entering Action Group [setQtyUsesDecimalsConfig] AdminSetQtyUsesDecimalsConfigActionGroup");
		$I->selectOption("//*[@name='product[stock_data][is_qty_decimal]']", "Yes"); // stepKey: setQtyUsesDecimalsConfigSetQtyUsesDecimalsConfig
		$I->comment("Exiting Action Group [setQtyUsesDecimalsConfig] AdminSetQtyUsesDecimalsConfigActionGroup");
		$I->comment("Entering Action Group [setEnableQtyIncrements] AdminSetEnableQtyIncrementsActionGroup");
		$I->scrollTo("//*[@name='product[stock_data][enable_qty_increments]']"); // stepKey: scrollToEnableQtyIncrementsSetEnableQtyIncrements
		$I->click("//input[@name='product[stock_data][use_config_enable_qty_inc]']"); // stepKey: clickOnEnableQtyIncrementsUseConfigSettingsCheckboxSetEnableQtyIncrements
		$I->selectOption("//*[@name='product[stock_data][enable_qty_increments]']", "Yes"); // stepKey: setEnableQtyIncrementsSetEnableQtyIncrements
		$I->comment("Exiting Action Group [setEnableQtyIncrements] AdminSetEnableQtyIncrementsActionGroup");
		$I->comment("Entering Action Group [setQtyIncrementsValue] AdminSetQtyIncrementsForProductActionGroup");
		$I->scrollTo("//input[@name='product[stock_data][use_config_qty_increments]']"); // stepKey: scrollToQtyIncrementsUseConfigSettingsSetQtyIncrementsValue
		$I->click("//input[@name='product[stock_data][use_config_qty_increments]']"); // stepKey: clickOnQtyIncrementsUseConfigSettingsSetQtyIncrementsValue
		$I->scrollTo("//input[@name='product[stock_data][qty_increments]']"); // stepKey: scrollToQtyIncrementsSetQtyIncrementsValue
		$I->fillField("//input[@name='product[stock_data][qty_increments]']", "2.14"); // stepKey: fillQtyIncrementsSetQtyIncrementsValue
		$I->comment("Exiting Action Group [setQtyIncrementsValue] AdminSetQtyIncrementsForProductActionGroup");
		$I->comment("Entering Action Group [fillMiniAllowedQty] AdminSetMinAllowedQtyForProductActionGroup");
		$I->uncheckOption("//*[@name='product[stock_data][use_config_min_sale_qty]']"); // stepKey: uncheckMiniQtyCheckBoxFillMiniAllowedQty
		$I->fillField("//*[@name='product[stock_data][min_sale_qty]']", "2.14"); // stepKey: fillMinAllowedQtyFillMiniAllowedQty
		$I->comment("Exiting Action Group [fillMiniAllowedQty] AdminSetMinAllowedQtyForProductActionGroup");
		$I->comment("Entering Action Group [clickOnDoneButton] AdminSubmitAdvancedInventoryFormActionGroup");
		$I->click("//aside[contains(@class,'product_form_product_form_advanced_inventory_modal')]//button[contains(@data-role,'action')]"); // stepKey: clickOnDoneButtonClickOnDoneButton
		$I->waitForPageLoad(5); // stepKey: clickOnDoneButtonClickOnDoneButtonWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForProductPageToLoadClickOnDoneButton
		$I->comment("Exiting Action Group [clickOnDoneButton] AdminSubmitAdvancedInventoryFormActionGroup");
		$I->comment("Step3. Save the product");
		$I->comment("Entering Action Group [clickOnSaveButton] AdminProductFormSaveActionGroup");
		$I->click("#save-button"); // stepKey: saveProductClickOnSaveButton
		$I->waitForPageLoad(30); // stepKey: saveProductClickOnSaveButtonWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForProductSavingClickOnSaveButton
		$I->comment("Exiting Action Group [clickOnSaveButton] AdminProductFormSaveActionGroup");
		$I->comment("Step4. Open *Customer view* (Go to *Store Front*). Open *prod1* page (Find via search and click on product name)");
		$I->comment("Step5. Log in to Storefront as Customer");
		$I->comment("Entering Action Group [signUpNewUser] LoginToStorefrontActionGroup");
		$I->amOnPage("/customer/account/login/"); // stepKey: amOnSignInPageSignUpNewUser
		$I->waitForPageLoad(30); // stepKey: waitPageFullyLoadedSignUpNewUser
		$I->waitForElementVisible("#email", 30); // stepKey: waitFormAppearsSignUpNewUser
		$I->fillField("#email", $I->retrieveEntityField('createSimpleUsCustomer', 'email', 'test')); // stepKey: fillEmailSignUpNewUser
		$I->fillField("#pass", $I->retrieveEntityField('createSimpleUsCustomer', 'password', 'test')); // stepKey: fillPasswordSignUpNewUser
		$I->click("#send2"); // stepKey: clickSignInAccountButtonSignUpNewUser
		$I->waitForPageLoad(30); // stepKey: clickSignInAccountButtonSignUpNewUserWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCustomerLoggedInSignUpNewUser
		$I->comment("Exiting Action Group [signUpNewUser] LoginToStorefrontActionGroup");
		$I->comment("Step6. Go to product page");
		$I->amOnPage($I->retrieveEntityField('createSimpleProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: navigateToSimpleProductPage
		$I->waitForPageLoad(30); // stepKey: waitForCatalogPageLoad
		$I->comment("Step7. Add Product to Shopping Cart");
		$I->comment("Entering Action Group [addToCartFromStorefrontProductPage] AddToCartFromStorefrontProductPageActionGroup");
		$I->click("#product-addtocart-button"); // stepKey: addToCartAddToCartFromStorefrontProductPage
		$I->waitForPageLoad(60); // stepKey: addToCartAddToCartFromStorefrontProductPageWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForAddToCartAddToCartFromStorefrontProductPage
		$I->waitForElementNotVisible("//button/span[text()='Adding...']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddingAddToCartFromStorefrontProductPage
		$I->waitForElementNotVisible("//button/span[text()='Added']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddedAddToCartFromStorefrontProductPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAddToCartFromStorefrontProductPage
		$I->waitForElementVisible("div.message-success.success.message", 30); // stepKey: waitForSuccessMessageAddToCartFromStorefrontProductPage
		$I->see("You added " . $I->retrieveEntityField('createSimpleProduct', 'name', 'test') . " to your shopping cart.", "div.message-success.success.message"); // stepKey: seeAddToCartSuccessMessageAddToCartFromStorefrontProductPage
		$I->comment("Exiting Action Group [addToCartFromStorefrontProductPage] AddToCartFromStorefrontProductPageActionGroup");
		$I->comment("Step8. Navigate to checkout");
		$I->comment("Entering Action Group [openCheckoutPage] StorefrontOpenCheckoutPageActionGroup");
		$I->amOnPage("/checkout"); // stepKey: openCheckoutPageOpenCheckoutPage
		$I->waitForPageLoad(30); // stepKey: waitForCheckoutPageLoadedOpenCheckoutPage
		$I->comment("Exiting Action Group [openCheckoutPage] StorefrontOpenCheckoutPageActionGroup");
		$I->comment("Step9. Click next button to open payment section");
		$I->comment("Entering Action Group [clickNext] StorefrontCheckoutClickNextButtonActionGroup");
		$I->waitForElementVisible("button.button.action.continue.primary", 30); // stepKey: waitForNextButtonClickNext
		$I->waitForPageLoad(30); // stepKey: waitForNextButtonClickNextWaitForPageLoad
		$I->click("button.button.action.continue.primary"); // stepKey: clickOnNextButtonClickNext
		$I->waitForPageLoad(30); // stepKey: clickOnNextButtonClickNextWaitForPageLoad
		$I->comment("Exiting Action Group [clickNext] StorefrontCheckoutClickNextButtonActionGroup");
		$I->comment("Step10. Click place order");
		$I->comment("Entering Action Group [placeOrder] ClickPlaceOrderActionGroup");
		$I->waitForElement(".payment-method._active button.action.primary.checkout", 30); // stepKey: waitForPlaceOrderButtonPlaceOrder
		$I->waitForPageLoad(30); // stepKey: waitForPlaceOrderButtonPlaceOrderWaitForPageLoad
		$I->click(".payment-method._active button.action.primary.checkout"); // stepKey: clickPlaceOrderPlaceOrder
		$I->waitForPageLoad(30); // stepKey: clickPlaceOrderPlaceOrderWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCheckoutPlaceOrder
		$I->see("Thank you for your purchase!", ".page-title"); // stepKey: waitForLoadSuccessPagePlaceOrder
		$I->comment("Exiting Action Group [placeOrder] ClickPlaceOrderActionGroup");
		$grabOrderNumber = $I->grabTextFrom(".order-number>strong"); // stepKey: grabOrderNumber
		$I->comment("Step11. Go to admin Order page for newly created order");
		$I->comment("Entering Action Group [filterOrdersGridById] OpenOrderByIdActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/sales/order/"); // stepKey: navigateToOrderGridPageFilterOrdersGridById
		$I->waitForPageLoad(30); // stepKey: waitForOrdersPageFilterOrdersGridById
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clearExistingOrderFiltersFilterOrdersGridById
		$I->waitForPageLoad(30); // stepKey: clearExistingOrderFiltersFilterOrdersGridByIdWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForClearFiltersFilterOrdersGridById
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openOrderGridFiltersFilterOrdersGridById
		$I->waitForPageLoad(30); // stepKey: openOrderGridFiltersFilterOrdersGridByIdWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForClickFiltersFilterOrdersGridById
		$I->fillField(".admin__data-grid-filters input[name='increment_id']", $grabOrderNumber); // stepKey: fillOrderIdFilterFilterOrdersGridById
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickOrderApplyFiltersFilterOrdersGridById
		$I->waitForPageLoad(30); // stepKey: clickOrderApplyFiltersFilterOrdersGridByIdWaitForPageLoad
		$I->click("table.data-grid tbody > tr:nth-of-type(1)"); // stepKey: openOrderViewPageFilterOrdersGridById
		$I->waitForPageLoad(60); // stepKey: openOrderViewPageFilterOrdersGridByIdWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForOrderViewPageOpenedFilterOrdersGridById
		$I->waitForPageLoad(30); // stepKey: waitForApplyFiltersFilterOrdersGridById
		$I->comment("Exiting Action Group [filterOrdersGridById] OpenOrderByIdActionGroup");
		$I->click("#order_ship"); // stepKey: clickShipAction
		$I->waitForPageLoad(30); // stepKey: clickShipActionWaitForPageLoad
		$I->click("button.action-default.save.submit-button"); // stepKey: clickSubmitShipment
		$I->waitForPageLoad(60); // stepKey: clickSubmitShipmentWaitForPageLoad
		$I->comment("Entering Action Group [goToOrderHistoryPage] StorefrontNavigateToCustomerOrdersHistoryPageActionGroup");
		$I->amOnPage("sales/order/history/"); // stepKey: amOnTheCustomerPageGoToOrderHistoryPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadGoToOrderHistoryPage
		$I->comment("Exiting Action Group [goToOrderHistoryPage] StorefrontNavigateToCustomerOrdersHistoryPageActionGroup");
		$I->comment("Step12. Go to Customer Order Shipment Page and Checking the correctness of displayed Qty Shipped");
		$I->amOnPage("sales/order/shipment/order_id/{$grabOrderNumber}"); // stepKey: amOnOrderShipmentPage
		$I->waitForPageLoad(30); // stepKey: waitForOrderShipmentsPageLoad
		$I->comment("Entering Action Group [verifyAssertOrderShipments] AssertStorefrontOrderShipmentsQtyShippedActionGroup");
		$grabSalesOrderQtyShippedVerifyAssertOrderShipments = $I->grabTextFrom("//td[@data-th='Qty Shipped']"); // stepKey: grabSalesOrderQtyShippedVerifyAssertOrderShipments
		$I->assertEquals("2.14", "$grabSalesOrderQtyShippedVerifyAssertOrderShipments"); // stepKey: assertOrderQtyShippedVerifyAssertOrderShipments
		$I->comment("Exiting Action Group [verifyAssertOrderShipments] AssertStorefrontOrderShipmentsQtyShippedActionGroup");
	}
}
