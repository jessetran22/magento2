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
 * @Title("MC-11064: Out of Stock Product is Not Visible in Category")
 * @Description("Login as admin and check out of stock product is not visible in category<h3>Test files</h3>app/code/Magento/Catalog/Test/Mftf/Test/AdminCheckOutOfStockProductIsNotVisibleInCategoryTest.xml<br>")
 * @TestCaseId("MC-11064")
 * @group mtf_migrated
 */
class AdminCheckOutOfStockProductIsNotVisibleInCategoryTestCest
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
    }
	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _before(AcceptanceTester $I)
	{
		$I->comment("Login as admin");
		$I->comment("Entering Action Group [login] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLogin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLogin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLogin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLogin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLogin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLogin
		$I->comment("Exiting Action Group [login] AdminLoginActionGroup");
		$I->comment("Create Category");
		$I->createEntity("createCategory", "hook", "SimpleSubCategory", [], []); // stepKey: createCategory
		$I->comment("Create Simple Product");
		$I->createEntity("createSimpleProduct", "hook", "SimpleProduct", ["createCategory"], []); // stepKey: createSimpleProduct
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Delete created entity");
		$I->deleteEntity("createCategory", "hook"); // stepKey: deleteCategory
		$I->deleteEntity("createSimpleProduct", "hook"); // stepKey: deleteSimpleProduct
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
	 * @Stories({"Manage products"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Features({"Catalog"})
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminCheckOutOfStockProductIsNotVisibleInCategoryTest(AcceptanceTester $I)
	{
		$I->comment("Open Product Index Page and filter the product");
		$I->comment("Entering Action Group [openProductIndexPage] AdminOpenProductIndexPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: goToProductIndexPageOpenProductIndexPage
		$I->waitForPageLoad(30); // stepKey: waitForProductIndexPageLoadOpenProductIndexPage
		$I->comment("Exiting Action Group [openProductIndexPage] AdminOpenProductIndexPageActionGroup");
		$I->comment("Entering Action Group [filterProduct] FilterProductGridBySkuActionGroup");
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersFilterProduct
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersFilterProductWaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFiltersFilterProduct
		$I->fillField("input.admin__control-text[name='sku']", "SimpleProduct" . msq("SimpleProduct")); // stepKey: fillProductSkuFilterFilterProduct
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersFilterProduct
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersFilterProductWaitForPageLoad
		$I->waitForElementNotVisible(".admin__data-grid-loading-mask[data-component*='product_listing']", 30); // stepKey: waitForFilteredGridLoadFilterProduct
		$I->comment("Exiting Action Group [filterProduct] FilterProductGridBySkuActionGroup");
		$I->comment("Update product Advanced Inventory Setting");
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
		$I->comment("Entering Action Group [setManageStockConfig] AdminSetManageStockConfigActionGroup");
		$I->uncheckOption("//input[@name='product[stock_data][use_config_manage_stock]']"); // stepKey: uncheckConfigSettingSetManageStockConfig
		$I->selectOption("//*[@name='product[stock_data][manage_stock]']", "Yes"); // stepKey: setManageStockConfigSetManageStockConfig
		$I->waitForPageLoad(30); // stepKey: setManageStockConfigSetManageStockConfigWaitForPageLoad
		$I->comment("Exiting Action Group [setManageStockConfig] AdminSetManageStockConfigActionGroup");
		$I->comment("Entering Action Group [fillProductQty] AdminFillAdvancedInventoryQtyActionGroup");
		$I->fillField("//div[@class='modal-inner-wrap']//input[@name='product[quantity_and_stock_status][qty]']", "5"); // stepKey: fillQtyFillProductQty
		$I->comment("Exiting Action Group [fillProductQty] AdminFillAdvancedInventoryQtyActionGroup");
		$I->comment("Entering Action Group [fillMiniAllowedQty] AdminSetMinAllowedQtyForProductActionGroup");
		$I->uncheckOption("//*[@name='product[stock_data][use_config_min_sale_qty]']"); // stepKey: uncheckMiniQtyCheckBoxFillMiniAllowedQty
		$I->fillField("//*[@name='product[stock_data][min_sale_qty]']", "1"); // stepKey: fillMinAllowedQtyFillMiniAllowedQty
		$I->comment("Exiting Action Group [fillMiniAllowedQty] AdminSetMinAllowedQtyForProductActionGroup");
		$I->comment("Entering Action Group [fillMaxAllowedQty] AdminSetMaxAllowedQtyForProductActionGroup");
		$I->uncheckOption("//*[@name='product[stock_data][use_config_max_sale_qty]']"); // stepKey: uncheckMaxQtyCheckBoxFillMaxAllowedQty
		$I->fillField("//*[@name='product[stock_data][max_sale_qty]']", "1000"); // stepKey: fillMaxAllowedQtyFillMaxAllowedQty
		$I->comment("Exiting Action Group [fillMaxAllowedQty] AdminSetMaxAllowedQtyForProductActionGroup");
		$I->comment("Entering Action Group [setQtyUsesDecimalsConfig] AdminSetQtyUsesDecimalsConfigActionGroup");
		$I->selectOption("//*[@name='product[stock_data][is_qty_decimal]']", "Yes"); // stepKey: setQtyUsesDecimalsConfigSetQtyUsesDecimalsConfig
		$I->comment("Exiting Action Group [setQtyUsesDecimalsConfig] AdminSetQtyUsesDecimalsConfigActionGroup");
		$I->comment("Entering Action Group [fillNotifyBelowQty] AdminSetNotifyBelowQtyValueActionGroup");
		$I->uncheckOption("//*[@name='product[stock_data][use_config_notify_stock_qty]']"); // stepKey: uncheckNotifyBelowQtyCheckBoxFillNotifyBelowQty
		$I->fillField("//*[@name='product[stock_data][notify_stock_qty]']", "1"); // stepKey: fillNotifyBelowQtyFillNotifyBelowQty
		$I->comment("Exiting Action Group [fillNotifyBelowQty] AdminSetNotifyBelowQtyValueActionGroup");
		$I->comment("Entering Action Group [selectOutOfStock] AdminSetStockStatusConfigActionGroup");
		$I->selectOption("//div[@class='modal-inner-wrap']//select[@name='product[quantity_and_stock_status][is_in_stock]']", "Out of Stock"); // stepKey: selectStockStatusSelectOutOfStock
		$I->comment("Exiting Action Group [selectOutOfStock] AdminSetStockStatusConfigActionGroup");
		$I->comment("Entering Action Group [clickDoneButton] AdminSubmitAdvancedInventoryFormActionGroup");
		$I->click("//aside[contains(@class,'product_form_product_form_advanced_inventory_modal')]//button[contains(@data-role,'action')]"); // stepKey: clickOnDoneButtonClickDoneButton
		$I->waitForPageLoad(5); // stepKey: clickOnDoneButtonClickDoneButtonWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForProductPageToLoadClickDoneButton
		$I->comment("Exiting Action Group [clickDoneButton] AdminSubmitAdvancedInventoryFormActionGroup");
		$I->comment("Entering Action Group [saveProduct] SaveProductFormActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollTopPageProductSaveProduct
		$I->waitForElementVisible("#save-button", 30); // stepKey: waitForSaveProductButtonSaveProduct
		$I->waitForPageLoad(30); // stepKey: waitForSaveProductButtonSaveProductWaitForPageLoad
		$I->click("#save-button"); // stepKey: clickSaveProductSaveProduct
		$I->waitForPageLoad(30); // stepKey: clickSaveProductSaveProductWaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitProductSaveSuccessMessageSaveProduct
		$I->dontSee(".message-warning"); // stepKey: dontSeeWarningMessageSaveProduct
		$I->see("You saved the product.", "#messages div.message-success"); // stepKey: seeSaveConfirmationSaveProduct
		$I->comment("Exiting Action Group [saveProduct] SaveProductFormActionGroup");
		$I->comment("Verify product is not visible in category store front page");
		$I->comment("Entering Action Group [doNotSeeProductInCategoryPage] AssertStorefrontProductAbsentOnCategoryPageActionGroup");
		$I->amOnPage("/" . $I->retrieveEntityField('createCategory', 'name', 'test') . ".html"); // stepKey: navigateToCategoryPageDoNotSeeProductInCategoryPage
		$I->waitForPageLoad(30); // stepKey: waitForCategoryPageLoadDoNotSeeProductInCategoryPage
		$I->dontSee("{{Simple Product " . msq("SimpleProduct") . "}}", ".product-item-name"); // stepKey: assertProductIsNotPresentDoNotSeeProductInCategoryPage
		$I->comment("Exiting Action Group [doNotSeeProductInCategoryPage] AssertStorefrontProductAbsentOnCategoryPageActionGroup");
		$I->comment("Verify Product In Store Front");
		$I->comment("Entering Action Group [seeProductOnStorefront] StorefrontCheckProductStockStatus");
		$I->amOnPage("/" . $I->retrieveEntityField('createSimpleProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: navigateToProductPageSeeProductOnStorefront
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoadSeeProductOnStorefront
		$I->see($I->retrieveEntityField('createSimpleProduct', 'name', 'test'), ".base"); // stepKey: seeProductNameSeeProductOnStorefront
		$I->see("Out of stock"); // stepKey: assertProductStockStatusSeeProductOnStorefront
		$I->comment("Exiting Action Group [seeProductOnStorefront] StorefrontCheckProductStockStatus");
	}
}
