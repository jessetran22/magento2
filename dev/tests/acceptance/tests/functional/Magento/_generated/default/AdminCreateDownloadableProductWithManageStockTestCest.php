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
 * @Title("MC-14510: Create downloadable product with manage stock test")
 * @Description("Admin should be able to create downloadable product with manage stock<h3>Test files</h3>app/code/Magento/Downloadable/Test/Mftf/Test/AdminCreateDownloadableProductWithManageStockTest.xml<br>")
 * @TestCaseId("MC-14510")
 * @group Downloadable
 * @group mtf_migrated
 */
class AdminCreateDownloadableProductWithManageStockTestCest
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
		$addDownloadableDomain = $I->magentoCLI("downloadable:domains:add static.magento.com", 60); // stepKey: addDownloadableDomain
		$I->comment($addDownloadableDomain);
		$I->comment("Create category");
		$I->createEntity("createCategory", "hook", "SimpleSubCategory", [], []); // stepKey: createCategory
		$I->comment("Login as admin");
		$I->comment("Entering Action Group [LoginAsAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdminWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin
		$I->comment("Exiting Action Group [LoginAsAdmin] AdminLoginActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$removeDownloadableDomain = $I->magentoCLI("downloadable:domains:remove static.magento.com", 60); // stepKey: removeDownloadableDomain
		$I->comment($removeDownloadableDomain);
		$I->comment("Delete category");
		$I->deleteEntity("createCategory", "hook"); // stepKey: deleteCategory
		$I->comment("Delete created downloadable product");
		$I->comment("Entering Action Group [deleteProduct] DeleteProductUsingProductGridActionGroup");
		$I->comment("TODO use other action group for filtering grid when MQE-539 is implemented");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: visitAdminProductPageDeleteProduct
		$I->waitForPageLoad(60); // stepKey: waitForPageLoadInitialDeleteProduct
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersInitialDeleteProduct
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersInitialDeleteProductWaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFiltersDeleteProduct
		$I->fillField("input.admin__control-text[name='sku']", "downloadableproduct" . msq("DownloadableProduct")); // stepKey: fillProductSkuFilterDeleteProduct
		$I->fillField("input.admin__control-text[name='name']", "DownloadableProduct" . msq("DownloadableProduct")); // stepKey: fillProductNameFilterDeleteProduct
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersDeleteProduct
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersDeleteProductWaitForPageLoad
		$I->see("downloadableproduct" . msq("DownloadableProduct"), "//tr[1]//td[count(//div[@data-role='grid-wrapper']//tr//th[normalize-space(.)='SKU']/preceding-sibling::th) +1 ]"); // stepKey: seeProductSkuInGridDeleteProduct
		$I->click("div[data-role='grid-wrapper'] th.data-grid-multicheck-cell button.action-multicheck-toggle"); // stepKey: openMulticheckDropdownDeleteProduct
		$I->click("//div[@data-role='grid-wrapper']//th[contains(@class, data-grid-multicheck-cell)]//li//span[text() = 'Select All']"); // stepKey: selectAllProductInFilteredGridDeleteProduct
		$I->click("div.admin__data-grid-header-row.row div.action-select-wrap button.action-select"); // stepKey: clickActionDropdownDeleteProduct
		$I->waitForPageLoad(30); // stepKey: clickActionDropdownDeleteProductWaitForPageLoad
		$I->click("//div[contains(@class,'admin__data-grid-header-row') and contains(@class, 'row')]//div[contains(@class, 'action-select-wrap')]//ul/li/span[text() = 'Delete']"); // stepKey: clickDeleteActionDeleteProduct
		$I->waitForPageLoad(30); // stepKey: clickDeleteActionDeleteProductWaitForPageLoad
		$I->waitForElementVisible(".modal-popup.confirm h1.modal-title", 30); // stepKey: waitForConfirmModalDeleteProduct
		$I->click(".modal-popup.confirm button.action-accept"); // stepKey: confirmProductDeleteDeleteProduct
		$I->waitForPageLoad(60); // stepKey: confirmProductDeleteDeleteProductWaitForPageLoad
		$I->comment("Exiting Action Group [deleteProduct] DeleteProductUsingProductGridActionGroup");
		$I->comment("Log out");
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
	 * @Features({"Downloadable"})
	 * @Stories({"Create Downloadable Product"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminCreateDownloadableProductWithManageStockTest(AcceptanceTester $I)
	{
		$I->comment("Create downloadable product");
		$I->comment("Entering Action Group [amOnProductGridPage] AdminOpenProductIndexPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: goToProductIndexPageAmOnProductGridPage
		$I->waitForPageLoad(30); // stepKey: waitForProductIndexPageLoadAmOnProductGridPage
		$I->comment("Exiting Action Group [amOnProductGridPage] AdminOpenProductIndexPageActionGroup");
		$I->comment("Entering Action Group [createProduct] GoToSpecifiedCreateProductPageActionGroup");
		$I->comment("actionGroup:GoToSpecifiedCreateProductPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: navigateToProductIndexCreateProduct
		$I->click(".action-toggle.primary.add"); // stepKey: clickAddProductDropdownCreateProduct
		$I->waitForPageLoad(30); // stepKey: clickAddProductDropdownCreateProductWaitForPageLoad
		$I->click(".item[data-ui-id='products-list-add-new-product-button-item-downloadable']"); // stepKey: clickAddProductCreateProduct
		$I->waitForPageLoad(30); // stepKey: waitForFormToLoadCreateProduct
		$I->comment("Exiting Action Group [createProduct] GoToSpecifiedCreateProductPageActionGroup");
		$I->comment("Fill downloadable product values");
		$I->comment("Entering Action Group [fillDownloadableProductForm] FillMainProductFormNoWeightActionGroup");
		$I->fillField(".admin__field[data-index=name] input", "DownloadableProduct" . msq("DownloadableProduct")); // stepKey: fillProductNameFillDownloadableProductForm
		$I->fillField(".admin__field[data-index=sku] input", "downloadableproduct" . msq("DownloadableProduct")); // stepKey: fillProductSkuFillDownloadableProductForm
		$I->fillField(".admin__field[data-index=price] input", "50.99"); // stepKey: fillProductPriceFillDownloadableProductForm
		$I->fillField(".admin__field[data-index=qty] input", "100"); // stepKey: fillProductQtyFillDownloadableProductForm
		$I->selectOption("select[name='product[quantity_and_stock_status][is_in_stock]']", "1"); // stepKey: selectStockStatusFillDownloadableProductForm
		$I->waitForPageLoad(30); // stepKey: selectStockStatusFillDownloadableProductFormWaitForPageLoad
		$I->selectOption("select[name='product[product_has_weight]']", "This item has no weight"); // stepKey: selectWeightFillDownloadableProductForm
		$I->comment("Exiting Action Group [fillDownloadableProductForm] FillMainProductFormNoWeightActionGroup");
		$I->comment("Add advanced inventory data to downloadable product");
		$I->comment("Entering Action Group [clickOnAdvancedInventoryLink] AdminClickOnAdvancedInventoryLinkActionGroup");
		$I->click("button[data-index='advanced_inventory_button'].action-additional"); // stepKey: clickOnAdvancedInventoryLinkClickOnAdvancedInventoryLink
		$I->waitForPageLoad(30); // stepKey: clickOnAdvancedInventoryLinkClickOnAdvancedInventoryLinkWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForAdvancedInventoryPageToLoadClickOnAdvancedInventoryLink
		$I->comment("Wait for close button appeared. That means animation finished and modal window is fully visible");
		$I->waitForElementVisible(".product_form_product_form_advanced_inventory_modal button.action-close", 30); // stepKey: waitForCloseButtonAppearedClickOnAdvancedInventoryLink
		$I->waitForPageLoad(30); // stepKey: waitForCloseButtonAppearedClickOnAdvancedInventoryLinkWaitForPageLoad
		$I->comment("Exiting Action Group [clickOnAdvancedInventoryLink] AdminClickOnAdvancedInventoryLinkActionGroup");
		$I->comment("Entering Action Group [fillAdvancedInventoryQty] AdminFillAdvancedInventoryQtyActionGroup");
		$I->fillField("//div[@class='modal-inner-wrap']//input[@name='product[quantity_and_stock_status][qty]']", "100"); // stepKey: fillQtyFillAdvancedInventoryQty
		$I->comment("Exiting Action Group [fillAdvancedInventoryQty] AdminFillAdvancedInventoryQtyActionGroup");
		$I->comment("Entering Action Group [fillAdvancedInventoryOutOfStockThreshold] AdminFillAdvancedInventoryOutOfStockThresholdActionGroup");
		$I->uncheckOption("//input[@name='product[stock_data][use_config_min_qty]']"); // stepKey: uncheckMiniQtyCheckBoxFillAdvancedInventoryOutOfStockThreshold
		$I->waitForPageLoad(30); // stepKey: uncheckMiniQtyCheckBoxFillAdvancedInventoryOutOfStockThresholdWaitForPageLoad
		$I->fillField("//*[@name='product[stock_data][min_qty]']", "100"); // stepKey: fillMiniAllowedQtyFillAdvancedInventoryOutOfStockThreshold
		$I->waitForPageLoad(30); // stepKey: fillMiniAllowedQtyFillAdvancedInventoryOutOfStockThresholdWaitForPageLoad
		$I->comment("Exiting Action Group [fillAdvancedInventoryOutOfStockThreshold] AdminFillAdvancedInventoryOutOfStockThresholdActionGroup");
		$I->comment("Entering Action Group [clickDoneBtn] AdminSubmitAdvancedInventoryFormActionGroup");
		$I->click("//aside[contains(@class,'product_form_product_form_advanced_inventory_modal')]//button[contains(@data-role,'action')]"); // stepKey: clickOnDoneButtonClickDoneBtn
		$I->waitForPageLoad(5); // stepKey: clickOnDoneButtonClickDoneBtnWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForProductPageToLoadClickDoneBtn
		$I->comment("Exiting Action Group [clickDoneBtn] AdminSubmitAdvancedInventoryFormActionGroup");
		$I->comment("Add downloadable product to category");
		$I->searchAndMultiSelectOption("div[data-index='category_ids']", [$I->retrieveEntityField('createCategory', 'name', 'test')]); // stepKey: fillCategory
		$I->waitForPageLoad(30); // stepKey: fillCategoryWaitForPageLoad
		$I->comment("Fill downloadable link information before the creation link");
		$I->comment("Entering Action Group [addDownloadableLinkInformation] AdminAddDownloadableLinkInformationActionGroup");
		$I->click("div[data-index='downloadable']"); // stepKey: openDownloadableSectionAddDownloadableLinkInformation
		$I->waitForPageLoad(30); // stepKey: openDownloadableSectionAddDownloadableLinkInformationWaitForPageLoad
		$I->checkOption("input[name='is_downloadable']"); // stepKey: checkOptionIsDownloadableAddDownloadableLinkInformation
		$I->fillField("input[name='product[links_title]']", "Downloadable Links"); // stepKey: fillLinkTitleAddDownloadableLinkInformation
		$I->fillField("input[name='product[samples_title]']", "Downloadable Samples"); // stepKey: fillSampleTitleAddDownloadableLinkInformation
		$I->comment("Exiting Action Group [addDownloadableLinkInformation] AdminAddDownloadableLinkInformationActionGroup");
		$I->comment("Links can be purchased separately");
		$I->checkOption("input[name='product[links_purchased_separately]']"); // stepKey: checkOptionPurchaseSeparately
		$I->comment("Add first downloadable link");
		$I->comment("Entering Action Group [addFirstDownloadableProductLink] AddDownloadableProductLinkWithMaxDownloadsActionGroup");
		$I->click("div[data-index='container_links'] button[data-action='add_new_row']"); // stepKey: clickLinkAddLinkButtonAddFirstDownloadableProductLink
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAddFirstDownloadableProductLink
		$I->fillField("input[name='downloadable[link][0][title]']", "Downloadable" . msq("downloadableLinkWithMaxDownloads")); // stepKey: fillDownloadableLinkTitleAddFirstDownloadableProductLink
		$I->fillField("input[name='downloadable[link][0][price]']", "1.00"); // stepKey: fillDownloadableLinkPriceAddFirstDownloadableProductLink
		$I->selectOption("select[name='downloadable[link][0][type]']", "Upload File"); // stepKey: selectDownloadableLinkFileTypeAddFirstDownloadableProductLink
		$I->selectOption("select[name='downloadable[link][0][sample][type]']", "URL"); // stepKey: selectDownloadableLinkSampleTypeAddFirstDownloadableProductLink
		$I->selectOption("select[name='downloadable[link][0][is_shareable]']", "Yes"); // stepKey: selectDownloadableLinkShareableAddFirstDownloadableProductLink
		$I->fillField("input[name='downloadable[link][0][number_of_downloads]']", "100"); // stepKey: fillDownloadableLinkMaxDownloadsAddFirstDownloadableProductLink
		$I->attachFile("div[data-index='container_links'] tr[data-repeat-index='0'] fieldset[data-index='container_file'] input[type='file']", "magento-logo.png"); // stepKey: fillDownloadableLinkUploadFileAddFirstDownloadableProductLink
		$I->fillField("input[name='downloadable[link][0][sample][url]']", "https://static.magento.com/sites/all/themes/mag_redesign/images/magento-logo.svg"); // stepKey: fillDownloadableLinkSampleUrlAddFirstDownloadableProductLink
		$I->comment("Exiting Action Group [addFirstDownloadableProductLink] AddDownloadableProductLinkWithMaxDownloadsActionGroup");
		$I->comment("Add second downloadable link");
		$I->comment("Entering Action Group [addSecondDownloadableProductLink] AddDownloadableProductLinkActionGroup");
		$I->click("div[data-index='container_links'] button[data-action='add_new_row']"); // stepKey: clickLinkAddLinkButtonAddSecondDownloadableProductLink
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAddSecondDownloadableProductLink
		$I->fillField("input[name='downloadable[link][1][title]']", "DownloadableLink" . msq("downloadableLink")); // stepKey: fillDownloadableLinkTitleAddSecondDownloadableProductLink
		$I->fillField("input[name='downloadable[link][1][price]']", "2.00"); // stepKey: fillDownloadableLinkPriceAddSecondDownloadableProductLink
		$I->selectOption("select[name='downloadable[link][1][type]']", "URL"); // stepKey: selectDownloadableLinkFileTypeAddSecondDownloadableProductLink
		$I->selectOption("select[name='downloadable[link][1][sample][type]']", "Upload File"); // stepKey: selectDownloadableLinkSampleTypeAddSecondDownloadableProductLink
		$I->selectOption("select[name='downloadable[link][1][is_shareable]']", "No"); // stepKey: selectDownloadableLinkShareableAddSecondDownloadableProductLink
		$I->checkOption("input[name='downloadable[link][1][is_unlimited]']"); // stepKey: checkDownloadableLinkUnlimitedAddSecondDownloadableProductLink
		$I->fillField("input[name='downloadable[link][1][link_url]']", "https://static.magento.com/sites/all/themes/mag_redesign/images/magento-logo.svg"); // stepKey: fillDownloadableLinkFileUrlAddSecondDownloadableProductLink
		$I->attachFile("div[data-index='container_links'] tr[data-repeat-index='1'] fieldset[data-index='container_sample'] input[type='file']", "magento-logo.png"); // stepKey: attachDownloadableLinkUploadSampleAddSecondDownloadableProductLink
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAfterFillingOutFormAddSecondDownloadableProductLink
		$I->comment("Exiting Action Group [addSecondDownloadableProductLink] AddDownloadableProductLinkActionGroup");
		$I->comment("Save product");
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
		$I->comment("Find downloadable product in grid");
		$I->comment("Entering Action Group [visitAdminProductPage] AdminOpenProductIndexPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: goToProductIndexPageVisitAdminProductPage
		$I->waitForPageLoad(30); // stepKey: waitForProductIndexPageLoadVisitAdminProductPage
		$I->comment("Exiting Action Group [visitAdminProductPage] AdminOpenProductIndexPageActionGroup");
		$I->comment("Entering Action Group [findCreatedConfigurableProduct] FilterProductGridBySkuActionGroup");
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersFindCreatedConfigurableProduct
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersFindCreatedConfigurableProductWaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFiltersFindCreatedConfigurableProduct
		$I->fillField("input.admin__control-text[name='sku']", "downloadableproduct" . msq("DownloadableProduct")); // stepKey: fillProductSkuFilterFindCreatedConfigurableProduct
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersFindCreatedConfigurableProduct
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersFindCreatedConfigurableProductWaitForPageLoad
		$I->waitForElementNotVisible(".admin__data-grid-loading-mask[data-component*='product_listing']", 30); // stepKey: waitForFilteredGridLoadFindCreatedConfigurableProduct
		$I->comment("Exiting Action Group [findCreatedConfigurableProduct] FilterProductGridBySkuActionGroup");
		$I->comment("Entering Action Group [clickOnProduct] AdminProductGridSectionClickFirstRowActionGroup");
		$I->click("tr.data-row:nth-of-type(1)"); // stepKey: clickOnProductPageClickOnProduct
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoadClickOnProduct
		$I->comment("Exiting Action Group [clickOnProduct] AdminProductGridSectionClickFirstRowActionGroup");
		$I->comment("Assert downloadable links in product form");
		$I->scrollTo("//div[@data-index='link']"); // stepKey: scrollToLinks
		$I->waitForPageLoad(30); // stepKey: scrollToLinksWaitForPageLoad
		$I->seeInField("input[name='downloadable[link][0][title]']", "Downloadable" . msq("downloadableLinkWithMaxDownloads")); // stepKey: seeFirstLinkTitle
		$I->seeInField("input[name='downloadable[link][1][title]']", "DownloadableLink" . msq("downloadableLink")); // stepKey: seeSecondLinkTitle
		$I->comment("Assert product is out of stock in store front");
		$I->amOnPage("downloadableproduct" . msq("DownloadableProduct") . ".html"); // stepKey: navigateToProductPage
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoad
		$I->see("DownloadableProduct" . msq("DownloadableProduct"), ".base"); // stepKey: seeProductNameInStoreFront
		$I->see("OUT OF STOCK", ".stock[title=Availability]>span"); // stepKey: seeProductStatusInStoreFront
	}
}
