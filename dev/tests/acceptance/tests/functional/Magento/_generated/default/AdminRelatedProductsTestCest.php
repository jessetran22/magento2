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
 * @Title("MC-116: Admin should be able to promote products as related")
 * @Description("Admin should be able to promote products as related<h3>Test files</h3>app/code/Magento/ConfigurableProduct/Test/Mftf/Test/AdminRelatedProductsTest.xml<br>")
 * @TestCaseId("MC-116")
 * @group configurable
 * @group product
 */
class AdminRelatedProductsTestCest
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
		$I->createEntity("categoryHandle", "hook", "SimpleSubCategory", [], []); // stepKey: categoryHandle
		$I->createEntity("simple1Handle", "hook", "SimpleProduct", ["categoryHandle"], []); // stepKey: simple1Handle
		$I->createEntity("simple2Handle", "hook", "SimpleProduct", ["categoryHandle"], []); // stepKey: simple2Handle
		$I->comment("TODO: Move configurable product creation to an actionGroup when MQE-697 is fixed");
		$I->createEntity("baseConfigProductHandle", "hook", "BaseConfigurableProduct", ["categoryHandle"], []); // stepKey: baseConfigProductHandle
		$I->createEntity("productAttributeHandle", "hook", "productDropDownAttribute", [], []); // stepKey: productAttributeHandle
		$I->createEntity("productAttributeOption1Handle", "hook", "productAttributeOption1", ["productAttributeHandle"], []); // stepKey: productAttributeOption1Handle
		$I->createEntity("productAttributeOption2Handle", "hook", "productAttributeOption2", ["productAttributeHandle"], []); // stepKey: productAttributeOption2Handle
		$I->createEntity("addToAttributeSetHandle", "hook", "AddToDefaultSet", ["productAttributeHandle"], []); // stepKey: addToAttributeSetHandle
		$I->getEntity("getAttributeOption1Handle", "hook", "ProductAttributeOptionGetter", ["productAttributeHandle"], null, 1); // stepKey: getAttributeOption1Handle
		$I->getEntity("getAttributeOption2Handle", "hook", "ProductAttributeOptionGetter", ["productAttributeHandle"], null, 2); // stepKey: getAttributeOption2Handle
		$I->createEntity("childProductHandle1", "hook", "SimpleOne", ["productAttributeHandle", "getAttributeOption1Handle"], []); // stepKey: childProductHandle1
		$I->createEntity("childProductHandle2", "hook", "SimpleOne", ["productAttributeHandle", "getAttributeOption2Handle"], []); // stepKey: childProductHandle2
		$I->createEntity("configProductOptionHandle", "hook", "ConfigurableProductTwoOptions", ["baseConfigProductHandle", "productAttributeHandle", "getAttributeOption1Handle", "getAttributeOption2Handle"], []); // stepKey: configProductOptionHandle
		$I->createEntity("configProductHandle1", "hook", "ConfigurableProductAddChild", ["baseConfigProductHandle", "childProductHandle1"], []); // stepKey: configProductHandle1
		$I->createEntity("configProductHandle2", "hook", "ConfigurableProductAddChild", ["baseConfigProductHandle", "childProductHandle2"], []); // stepKey: configProductHandle2
		$I->comment("Entering Action Group [loginAsAdmin1] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin1
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin1
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin1
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin1
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdmin1WaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin1
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin1
		$I->comment("Exiting Action Group [loginAsAdmin1] AdminLoginActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [amOnLogoutPage] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageAmOnLogoutPage
		$I->comment("Exiting Action Group [amOnLogoutPage] AdminLogoutActionGroup");
		$I->deleteEntity("simple1Handle", "hook"); // stepKey: deleteSimple1
		$I->deleteEntity("simple2Handle", "hook"); // stepKey: deleteSimple2
		$I->deleteEntity("childProductHandle1", "hook"); // stepKey: deleteChild1
		$I->deleteEntity("childProductHandle2", "hook"); // stepKey: deleteChild2
		$I->deleteEntity("baseConfigProductHandle", "hook"); // stepKey: deleteConfig
		$I->deleteEntity("categoryHandle", "hook"); // stepKey: deleteCategory
		$I->deleteEntity("productAttributeHandle", "hook"); // stepKey: deleteProductAttribute
		$I->comment("Reindex invalidated indices after product attribute has been created/deleted");
		$reindexInvalidatedIndices = $I->magentoCron("index", 90); // stepKey: reindexInvalidatedIndices
		$I->comment($reindexInvalidatedIndices);
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
	 * @Features({"ConfigurableProduct"})
	 * @Stories({"Promote Products as Related"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminRelatedProductsTest(AcceptanceTester $I)
	{
		$I->comment("Filter and edit simple product 1");
		$I->comment("Entering Action Group [productIndexPage] AdminOpenProductIndexPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: goToProductIndexPageProductIndexPage
		$I->waitForPageLoad(30); // stepKey: waitForProductIndexPageLoadProductIndexPage
		$I->comment("Exiting Action Group [productIndexPage] AdminOpenProductIndexPageActionGroup");
		$I->comment("Entering Action Group [resetProductGridColumnsInitial] ResetProductGridToDefaultViewActionGroup");
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersResetProductGridColumnsInitial
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersResetProductGridColumnsInitialWaitForPageLoad
		$I->click(".admin__data-grid-action-bookmarks button.admin__action-dropdown"); // stepKey: openViewBookmarksTabResetProductGridColumnsInitial
		$I->click("//div[contains(@class, 'admin__data-grid-action-bookmarks')]/ul/li/div/a[text() = 'Default View']"); // stepKey: resetToDefaultGridViewResetProductGridColumnsInitial
		$I->waitForPageLoad(30); // stepKey: resetToDefaultGridViewResetProductGridColumnsInitialWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForProductGridLoadResetProductGridColumnsInitial
		$I->see("Default View", ".admin__data-grid-action-bookmarks button.admin__action-dropdown"); // stepKey: seeDefaultViewSelectedResetProductGridColumnsInitial
		$I->comment("Exiting Action Group [resetProductGridColumnsInitial] ResetProductGridToDefaultViewActionGroup");
		$I->comment("Entering Action Group [filterProductGridSimple] FilterProductGridBySkuActionGroup");
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersFilterProductGridSimple
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersFilterProductGridSimpleWaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFiltersFilterProductGridSimple
		$I->fillField("input.admin__control-text[name='sku']", $I->retrieveEntityField('simple1Handle', 'sku', 'test')); // stepKey: fillProductSkuFilterFilterProductGridSimple
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersFilterProductGridSimple
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersFilterProductGridSimpleWaitForPageLoad
		$I->waitForElementNotVisible(".admin__data-grid-loading-mask[data-component*='product_listing']", 30); // stepKey: waitForFilteredGridLoadFilterProductGridSimple
		$I->comment("Exiting Action Group [filterProductGridSimple] FilterProductGridBySkuActionGroup");
		$I->comment("Entering Action Group [openProducForEditByClickingRow1Column2InProductGrid] OpenProductForEditByClickingRowXColumnYInProductGridActionGroup");
		$I->click("table.data-grid tr.data-row:nth-child(1) td:nth-child(2)"); // stepKey: openProductForEditOpenProducForEditByClickingRow1Column2InProductGrid
		$I->waitForPageLoad(30); // stepKey: openProductForEditOpenProducForEditByClickingRow1Column2InProductGridWaitForPageLoad
		$I->comment("Exiting Action Group [openProducForEditByClickingRow1Column2InProductGrid] OpenProductForEditByClickingRowXColumnYInProductGridActionGroup");
		$I->conditionalClick("//strong[@class='admin__collapsible-title']/span[contains(text(), 'Related Products')]", "//strong[@class='admin__collapsible-title']/span[contains(text(), 'Related Products')]/parent::*/parent::*[@data-state-collapsible='closed']", true); // stepKey: openRelatedProductTab
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad3
		$I->comment("TODO: move adding related product to a action group when nested action group is allowed (ref#: MQE-539)");
		$I->comment("Add related simple product to simple product");
		$I->click("button[data-index='button_related']"); // stepKey: clickAddRelatedProductButton
		$I->waitForPageLoad(30); // stepKey: clickAddRelatedProductButtonWaitForPageLoad
		$I->comment("Entering Action Group [filterProductGridSimple1] FilterProductGridBySkuActionGroup");
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersFilterProductGridSimple1
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersFilterProductGridSimple1WaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFiltersFilterProductGridSimple1
		$I->fillField("input.admin__control-text[name='sku']", $I->retrieveEntityField('simple2Handle', 'sku', 'test')); // stepKey: fillProductSkuFilterFilterProductGridSimple1
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersFilterProductGridSimple1
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersFilterProductGridSimple1WaitForPageLoad
		$I->waitForElementNotVisible(".admin__data-grid-loading-mask[data-component*='product_listing']", 30); // stepKey: waitForFilteredGridLoadFilterProductGridSimple1
		$I->comment("Exiting Action Group [filterProductGridSimple1] FilterProductGridBySkuActionGroup");
		$I->click(".modal-slide table.data-grid tr.data-row:nth-child(1) td:nth-child(1)"); // stepKey: selectSimpleTwo
		$I->waitForPageLoad(30); // stepKey: selectSimpleTwoWaitForPageLoad
		$I->click(".admin__data-grid-header button[data-action='grid-filter-reset']"); // stepKey: selectClearAll1
		$I->waitForPageLoad(30); // stepKey: selectClearAll1WaitForPageLoad
		$I->click("//aside[contains(@class, 'related_modal')]//button[contains(@class, 'action-primary')]"); // stepKey: addRelatedProductSelected1
		$I->waitForPageLoad(30); // stepKey: addRelatedProductSelected1WaitForPageLoad
		$I->comment("Add related config product to simple product");
		$I->click("button[data-index='button_related']"); // stepKey: clickAddRelatedProductButton2
		$I->waitForPageLoad(30); // stepKey: clickAddRelatedProductButton2WaitForPageLoad
		$I->comment("Entering Action Group [filterProductGridSimpleForRelatedConfig1] FilterProductGridBySkuActionGroup");
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersFilterProductGridSimpleForRelatedConfig1
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersFilterProductGridSimpleForRelatedConfig1WaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFiltersFilterProductGridSimpleForRelatedConfig1
		$I->fillField("input.admin__control-text[name='sku']", $I->retrieveEntityField('baseConfigProductHandle', 'sku', 'test')); // stepKey: fillProductSkuFilterFilterProductGridSimpleForRelatedConfig1
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersFilterProductGridSimpleForRelatedConfig1
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersFilterProductGridSimpleForRelatedConfig1WaitForPageLoad
		$I->waitForElementNotVisible(".admin__data-grid-loading-mask[data-component*='product_listing']", 30); // stepKey: waitForFilteredGridLoadFilterProductGridSimpleForRelatedConfig1
		$I->comment("Exiting Action Group [filterProductGridSimpleForRelatedConfig1] FilterProductGridBySkuActionGroup");
		$I->click(".modal-slide table.data-grid tr.data-row:nth-child(1) td:nth-child(1)"); // stepKey: selectConfigProduct
		$I->waitForPageLoad(30); // stepKey: selectConfigProductWaitForPageLoad
		$I->click(".admin__data-grid-header button[data-action='grid-filter-reset']"); // stepKey: selectClearAll2
		$I->waitForPageLoad(30); // stepKey: selectClearAll2WaitForPageLoad
		$I->click("//aside[contains(@class, 'related_modal')]//button[contains(@class, 'action-primary')]"); // stepKey: addRelatedProductSelected2
		$I->waitForPageLoad(30); // stepKey: addRelatedProductSelected2WaitForPageLoad
		$I->comment("Save simple product");
		$I->comment("Entering Action Group [saveRelatedProduct1] SaveProductFormActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollTopPageProductSaveRelatedProduct1
		$I->waitForElementVisible("#save-button", 30); // stepKey: waitForSaveProductButtonSaveRelatedProduct1
		$I->waitForPageLoad(30); // stepKey: waitForSaveProductButtonSaveRelatedProduct1WaitForPageLoad
		$I->click("#save-button"); // stepKey: clickSaveProductSaveRelatedProduct1
		$I->waitForPageLoad(30); // stepKey: clickSaveProductSaveRelatedProduct1WaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitProductSaveSuccessMessageSaveRelatedProduct1
		$I->dontSee(".message-warning"); // stepKey: dontSeeWarningMessageSaveRelatedProduct1
		$I->see("You saved the product.", "#messages div.message-success"); // stepKey: seeSaveConfirmationSaveRelatedProduct1
		$I->comment("Exiting Action Group [saveRelatedProduct1] SaveProductFormActionGroup");
		$I->comment("Assert related simple products for simple product in Admin Product Form");
		$I->comment("Entering Action Group [assertRelated1] AssertTextInAdminProductRelatedUpSellCrossSellSectionActionGroup");
		$I->conditionalClick("//strong[@class='admin__collapsible-title']/span[contains(text(), 'Related Products')]", "//strong[@class='admin__collapsible-title']/span[contains(text(), 'Related Products')]/parent::*/parent::*[@data-state-collapsible='closed']", true); // stepKey: openTabAssertRelated1
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAssertRelated1
		$I->see($I->retrieveEntityField('simple2Handle', 'name', 'test'), ".fieldset-wrapper.admin__fieldset-section[data-index='related']"); // stepKey: assertTextAssertRelated1
		$I->comment("Exiting Action Group [assertRelated1] AssertTextInAdminProductRelatedUpSellCrossSellSectionActionGroup");
		$I->comment("Assert related config products for simple product in Admin Product Form");
		$I->comment("Entering Action Group [assertRelated2] AssertTextInAdminProductRelatedUpSellCrossSellSectionActionGroup");
		$I->conditionalClick("//strong[@class='admin__collapsible-title']/span[contains(text(), 'Related Products')]", "//strong[@class='admin__collapsible-title']/span[contains(text(), 'Related Products')]/parent::*/parent::*[@data-state-collapsible='closed']", true); // stepKey: openTabAssertRelated2
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAssertRelated2
		$I->see($I->retrieveEntityField('baseConfigProductHandle', 'name', 'test'), ".fieldset-wrapper.admin__fieldset-section[data-index='related']"); // stepKey: assertTextAssertRelated2
		$I->comment("Exiting Action Group [assertRelated2] AssertTextInAdminProductRelatedUpSellCrossSellSectionActionGroup");
		$I->comment("Filter and edit config product");
		$I->comment("Entering Action Group [productIndexPage2] AdminOpenProductIndexPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: goToProductIndexPageProductIndexPage2
		$I->waitForPageLoad(30); // stepKey: waitForProductIndexPageLoadProductIndexPage2
		$I->comment("Exiting Action Group [productIndexPage2] AdminOpenProductIndexPageActionGroup");
		$I->comment("Entering Action Group [resetProductGridColumnsInitial2] ResetProductGridToDefaultViewActionGroup");
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersResetProductGridColumnsInitial2
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersResetProductGridColumnsInitial2WaitForPageLoad
		$I->click(".admin__data-grid-action-bookmarks button.admin__action-dropdown"); // stepKey: openViewBookmarksTabResetProductGridColumnsInitial2
		$I->click("//div[contains(@class, 'admin__data-grid-action-bookmarks')]/ul/li/div/a[text() = 'Default View']"); // stepKey: resetToDefaultGridViewResetProductGridColumnsInitial2
		$I->waitForPageLoad(30); // stepKey: resetToDefaultGridViewResetProductGridColumnsInitial2WaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForProductGridLoadResetProductGridColumnsInitial2
		$I->see("Default View", ".admin__data-grid-action-bookmarks button.admin__action-dropdown"); // stepKey: seeDefaultViewSelectedResetProductGridColumnsInitial2
		$I->comment("Exiting Action Group [resetProductGridColumnsInitial2] ResetProductGridToDefaultViewActionGroup");
		$I->comment("Entering Action Group [filterProductGridConfig] FilterProductGridBySkuActionGroup");
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersFilterProductGridConfig
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersFilterProductGridConfigWaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFiltersFilterProductGridConfig
		$I->fillField("input.admin__control-text[name='sku']", $I->retrieveEntityField('baseConfigProductHandle', 'sku', 'test')); // stepKey: fillProductSkuFilterFilterProductGridConfig
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersFilterProductGridConfig
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersFilterProductGridConfigWaitForPageLoad
		$I->waitForElementNotVisible(".admin__data-grid-loading-mask[data-component*='product_listing']", 30); // stepKey: waitForFilteredGridLoadFilterProductGridConfig
		$I->comment("Exiting Action Group [filterProductGridConfig] FilterProductGridBySkuActionGroup");
		$I->comment("Entering Action Group [openProducForEditByClickingRow1Column2InProductGrid2] OpenProductForEditByClickingRowXColumnYInProductGridActionGroup");
		$I->click("table.data-grid tr.data-row:nth-child(1) td:nth-child(2)"); // stepKey: openProductForEditOpenProducForEditByClickingRow1Column2InProductGrid2
		$I->waitForPageLoad(30); // stepKey: openProductForEditOpenProducForEditByClickingRow1Column2InProductGrid2WaitForPageLoad
		$I->comment("Exiting Action Group [openProducForEditByClickingRow1Column2InProductGrid2] OpenProductForEditByClickingRowXColumnYInProductGridActionGroup");
		$I->conditionalClick("//strong[@class='admin__collapsible-title']/span[contains(text(), 'Related Products')]", "//strong[@class='admin__collapsible-title']/span[contains(text(), 'Related Products')]/parent::*/parent::*[@data-state-collapsible='closed']", true); // stepKey: openRelatedProductTab2
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad7
		$I->comment("Add related simple product to config product");
		$I->click("button[data-index='button_related']"); // stepKey: clickAddRelatedProductButton3
		$I->waitForPageLoad(30); // stepKey: clickAddRelatedProductButton3WaitForPageLoad
		$I->comment("Entering Action Group [filterProductGridForConfig3] FilterProductGridBySkuActionGroup");
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersFilterProductGridForConfig3
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersFilterProductGridForConfig3WaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFiltersFilterProductGridForConfig3
		$I->fillField("input.admin__control-text[name='sku']", $I->retrieveEntityField('simple2Handle', 'sku', 'test')); // stepKey: fillProductSkuFilterFilterProductGridForConfig3
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersFilterProductGridForConfig3
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersFilterProductGridForConfig3WaitForPageLoad
		$I->waitForElementNotVisible(".admin__data-grid-loading-mask[data-component*='product_listing']", 30); // stepKey: waitForFilteredGridLoadFilterProductGridForConfig3
		$I->comment("Exiting Action Group [filterProductGridForConfig3] FilterProductGridBySkuActionGroup");
		$I->click(".modal-slide table.data-grid tr.data-row:nth-child(1) td:nth-child(1)"); // stepKey: selectSimpleTwo2
		$I->waitForPageLoad(30); // stepKey: selectSimpleTwo2WaitForPageLoad
		$I->click(".admin__data-grid-header button[data-action='grid-filter-reset']"); // stepKey: selectClearAll3
		$I->waitForPageLoad(30); // stepKey: selectClearAll3WaitForPageLoad
		$I->click("//aside[contains(@class, 'related_modal')]//button[contains(@class, 'action-primary')]"); // stepKey: addRelatedProductSelected3
		$I->waitForPageLoad(30); // stepKey: addRelatedProductSelected3WaitForPageLoad
		$I->comment("Save config product");
		$I->comment("Entering Action Group [saveRelatedProduct2] SaveProductFormActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollTopPageProductSaveRelatedProduct2
		$I->waitForElementVisible("#save-button", 30); // stepKey: waitForSaveProductButtonSaveRelatedProduct2
		$I->waitForPageLoad(30); // stepKey: waitForSaveProductButtonSaveRelatedProduct2WaitForPageLoad
		$I->click("#save-button"); // stepKey: clickSaveProductSaveRelatedProduct2
		$I->waitForPageLoad(30); // stepKey: clickSaveProductSaveRelatedProduct2WaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitProductSaveSuccessMessageSaveRelatedProduct2
		$I->dontSee(".message-warning"); // stepKey: dontSeeWarningMessageSaveRelatedProduct2
		$I->see("You saved the product.", "#messages div.message-success"); // stepKey: seeSaveConfirmationSaveRelatedProduct2
		$I->comment("Exiting Action Group [saveRelatedProduct2] SaveProductFormActionGroup");
		$I->comment("Assert related simple product for config product in Admin Product Form");
		$I->comment("Entering Action Group [assertRelated3] AssertTextInAdminProductRelatedUpSellCrossSellSectionActionGroup");
		$I->conditionalClick("//strong[@class='admin__collapsible-title']/span[contains(text(), 'Related Products')]", "//strong[@class='admin__collapsible-title']/span[contains(text(), 'Related Products')]/parent::*/parent::*[@data-state-collapsible='closed']", true); // stepKey: openTabAssertRelated3
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAssertRelated3
		$I->see($I->retrieveEntityField('simple2Handle', 'name', 'test'), ".fieldset-wrapper.admin__fieldset-section[data-index='related']"); // stepKey: assertTextAssertRelated3
		$I->comment("Exiting Action Group [assertRelated3] AssertTextInAdminProductRelatedUpSellCrossSellSectionActionGroup");
		$I->comment("Check storefront related products on simple product page");
		$I->amOnPage($I->retrieveEntityField('simple1Handle', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: navigateToSimpleProduct1Page
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad9
		$I->see("Check items to add to the cart", ".block.related .block-actions"); // stepKey: assertRelatedProductHeaderInStorefront1
		$I->see("select all", ".block.related .block-actions"); // stepKey: assertRelatedProductHeaderInStorefront2
		$I->see($I->retrieveEntityField('simple2Handle', 'name', 'test'), ".block.related .products.wrapper.grid.products-grid.products-related"); // stepKey: assertRelatedSimpleProductNameInStorefront
		$I->see($I->retrieveEntityField('baseConfigProductHandle', 'name', 'test'), ".block.related .products.wrapper.grid.products-grid.products-related"); // stepKey: assertRelatedConfigProductNameInStorefront
		$I->comment("Navigate to product page from related product link");
		$I->click("//*[@class='block related']//a[contains(text(), '" . $I->retrieveEntityField('baseConfigProductHandle', 'custom_attributes[url_key]', 'test') . "')]"); // stepKey: clickRelatedProductByName
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad11
		$I->seeInCurrentUrl($I->retrieveEntityField('baseConfigProductHandle', 'custom_attributes[url_key]', 'test')); // stepKey: seeInCurrentUrl
		$I->comment("Select option for configurable product");
		$I->selectOption("#product-options-wrapper .super-attribute-select", $I->retrieveEntityField('productAttributeOption1Handle', 'option[store_labels][0][label]', 'test')); // stepKey: configSelectOption
		$I->comment("Check storefront related products on config product page");
		$I->see($I->retrieveEntityField('simple2Handle', 'name', 'test'), ".block.related .products.wrapper.grid.products-grid.products-related"); // stepKey: assertRelatedSimpleProductNameInStorefront2
		$I->comment("Check related product in product page");
		$I->click("//*[@class='block related']//a[contains(text(), '" . $I->retrieveEntityField('simple2Handle', 'name', 'test') . "')]/parent::*/parent::*//input[@class='checkbox related']"); // stepKey: checkRelatedProcut
		$I->comment("Entering Action Group [addToCartFromStorefrontProductPage] AddToCartFromStorefrontProductPageActionGroup");
		$I->click("#product-addtocart-button"); // stepKey: addToCartAddToCartFromStorefrontProductPage
		$I->waitForPageLoad(60); // stepKey: addToCartAddToCartFromStorefrontProductPageWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForAddToCartAddToCartFromStorefrontProductPage
		$I->waitForElementNotVisible("//button/span[text()='Adding...']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddingAddToCartFromStorefrontProductPage
		$I->waitForElementNotVisible("//button/span[text()='Added']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddedAddToCartFromStorefrontProductPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAddToCartFromStorefrontProductPage
		$I->waitForElementVisible("div.message-success.success.message", 30); // stepKey: waitForSuccessMessageAddToCartFromStorefrontProductPage
		$I->see("You added " . $I->retrieveEntityField('baseConfigProductHandle', 'name', 'test') . " to your shopping cart.", "div.message-success.success.message"); // stepKey: seeAddToCartSuccessMessageAddToCartFromStorefrontProductPage
		$I->comment("Exiting Action Group [addToCartFromStorefrontProductPage] AddToCartFromStorefrontProductPageActionGroup");
		$I->see("2", "span.counter-number"); // stepKey: seeItemCounterInMiniCart
		$I->comment("Entering Action Group [assertOneProductNameInMiniCart] AssertOneProductNameInMiniCartActionGroup");
		$I->conditionalClick("a.showcart", "a.showcart.active", false); // stepKey: openMiniCartAssertOneProductNameInMiniCart
		$I->waitForElementVisible(".action.viewcart", 30); // stepKey: waitForViewAndEditCartVisibleAssertOneProductNameInMiniCart
		$I->waitForPageLoad(30); // stepKey: waitForViewAndEditCartVisibleAssertOneProductNameInMiniCartWaitForPageLoad
		$I->see($I->retrieveEntityField('baseConfigProductHandle', 'name', 'test'), ".minicart-items"); // stepKey: seeInMiniCartAssertOneProductNameInMiniCart
		$I->comment("Exiting Action Group [assertOneProductNameInMiniCart] AssertOneProductNameInMiniCartActionGroup");
		$I->comment("Entering Action Group [assertOneProductNameInMiniCart2] AssertOneProductNameInMiniCartActionGroup");
		$I->conditionalClick("a.showcart", "a.showcart.active", false); // stepKey: openMiniCartAssertOneProductNameInMiniCart2
		$I->waitForElementVisible(".action.viewcart", 30); // stepKey: waitForViewAndEditCartVisibleAssertOneProductNameInMiniCart2
		$I->waitForPageLoad(30); // stepKey: waitForViewAndEditCartVisibleAssertOneProductNameInMiniCart2WaitForPageLoad
		$I->see($I->retrieveEntityField('simple2Handle', 'name', 'test'), ".minicart-items"); // stepKey: seeInMiniCartAssertOneProductNameInMiniCart2
		$I->comment("Exiting Action Group [assertOneProductNameInMiniCart2] AssertOneProductNameInMiniCartActionGroup");
	}
}
