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
 * @Title("MC-6498: Update Virtual Product with Regular Price (Out of Stock) Visible in Search Only")
 * @Description("Test log in to Update Virtual Product and Update Virtual Product with Regular Price (Out of Stock) Visible in Search Only<h3>Test files</h3>app/code/Magento/Catalog/Test/Mftf/Test/AdminUpdateVirtualProductWithRegularPriceOutOfStockVisibleInSearchOnlyTest.xml<br>")
 * @TestCaseId("MC-6498")
 * @group catalog
 * @group mtf_migrated
 */
class AdminUpdateVirtualProductWithRegularPriceOutOfStockVisibleInSearchOnlyTestCest
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
		$I->comment("Entering Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdminWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin
		$I->comment("Exiting Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->createEntity("initialCategoryEntity", "hook", "SimpleSubCategory", [], []); // stepKey: initialCategoryEntity
		$I->createEntity("initialVirtualProduct", "hook", "defaultVirtualProduct", ["initialCategoryEntity"], []); // stepKey: initialVirtualProduct
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [deleteDefaultVirtualProduct] DeleteProductBySkuActionGroup");
		$I->comment("TODO use other action group for filtering grid when MQE-539 is implemented");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: visitAdminProductPageDeleteDefaultVirtualProduct
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersDeleteDefaultVirtualProduct
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersDeleteDefaultVirtualProductWaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFiltersDeleteDefaultVirtualProduct
		$I->fillField("input.admin__control-text[name='sku']", "virtual_sku" . msq("updateVirtualProductRegularPrice99OutOfStock")); // stepKey: fillProductSkuFilterDeleteDefaultVirtualProduct
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersDeleteDefaultVirtualProduct
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersDeleteDefaultVirtualProductWaitForPageLoad
		$I->see("virtual_sku" . msq("updateVirtualProductRegularPrice99OutOfStock"), "//tr[1]//td[count(//div[@data-role='grid-wrapper']//tr//th[normalize-space(.)='SKU']/preceding-sibling::th) +1 ]"); // stepKey: seeProductSkuInGridDeleteDefaultVirtualProduct
		$I->click("div[data-role='grid-wrapper'] th.data-grid-multicheck-cell button.action-multicheck-toggle"); // stepKey: openMulticheckDropdownDeleteDefaultVirtualProduct
		$I->click("//div[@data-role='grid-wrapper']//th[contains(@class, data-grid-multicheck-cell)]//li//span[text() = 'Select All']"); // stepKey: selectAllProductInFilteredGridDeleteDefaultVirtualProduct
		$I->click("div.admin__data-grid-header-row.row div.action-select-wrap button.action-select"); // stepKey: clickActionDropdownDeleteDefaultVirtualProduct
		$I->waitForPageLoad(30); // stepKey: clickActionDropdownDeleteDefaultVirtualProductWaitForPageLoad
		$I->click("//div[contains(@class,'admin__data-grid-header-row') and contains(@class, 'row')]//div[contains(@class, 'action-select-wrap')]//ul/li/span[text() = 'Delete']"); // stepKey: clickDeleteActionDeleteDefaultVirtualProduct
		$I->waitForPageLoad(30); // stepKey: clickDeleteActionDeleteDefaultVirtualProductWaitForPageLoad
		$I->waitForElementVisible("aside.confirm .modal-footer button.action-accept", 30); // stepKey: waitForConfirmModalDeleteDefaultVirtualProduct
		$I->waitForPageLoad(60); // stepKey: waitForConfirmModalDeleteDefaultVirtualProductWaitForPageLoad
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: confirmProductDeleteDeleteDefaultVirtualProduct
		$I->waitForPageLoad(60); // stepKey: confirmProductDeleteDeleteDefaultVirtualProductWaitForPageLoad
		$I->see("record(s) have been deleted.", "#messages div.message-success"); // stepKey: seeSuccessMessageDeleteDefaultVirtualProduct
		$I->comment("Exiting Action Group [deleteDefaultVirtualProduct] DeleteProductBySkuActionGroup");
		$I->deleteEntity("initialCategoryEntity", "hook"); // stepKey: deleteSimpleSubCategory
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
	 * @Stories({"Update Virtual Product"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Features({"Catalog"})
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminUpdateVirtualProductWithRegularPriceOutOfStockVisibleInSearchOnlyTest(AcceptanceTester $I)
	{
		$I->comment("Search default virtual product in the grid page");
		$I->comment("Entering Action Group [openProductCatalogPage1] AdminProductCatalogPageOpenActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/"); // stepKey: openProductCatalogPageOpenProductCatalogPage1
		$I->waitForPageLoad(30); // stepKey: waitForProductCatalogPageLoadOpenProductCatalogPage1
		$I->comment("Exiting Action Group [openProductCatalogPage1] AdminProductCatalogPageOpenActionGroup");
		$I->comment("Entering Action Group [searchProductGrid] SearchProductGridByKeywordActionGroup");
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersInitialSearchProductGrid
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersInitialSearchProductGridWaitForPageLoad
		$I->fillField("input#fulltext", $I->retrieveEntityField('initialVirtualProduct', 'name', 'test')); // stepKey: fillKeywordSearchFieldSearchProductGrid
		$I->click(".data-grid-search-control-wrap button.action-submit"); // stepKey: clickKeywordSearchSearchProductGrid
		$I->waitForPageLoad(30); // stepKey: clickKeywordSearchSearchProductGridWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForProductSearchSearchProductGrid
		$I->comment("Exiting Action Group [searchProductGrid] SearchProductGridByKeywordActionGroup");
		$I->click(".data-row:nth-of-type(1)"); // stepKey: clickFirstRowToVerifyCreatedVirtualProduct
		$I->waitForPageLoad(30); // stepKey: clickFirstRowToVerifyCreatedVirtualProductWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitUntilProductIsOpened
		$I->comment("Update virtual product with regular price(out of stock)");
		$I->fillField(".admin__field[data-index=name] input", "VirtualProduct" . msq("updateVirtualProductRegularPrice99OutOfStock")); // stepKey: fillProductName
		$I->fillField(".admin__field[data-index=sku] input", "virtual_sku" . msq("updateVirtualProductRegularPrice99OutOfStock")); // stepKey: fillProductSku
		$I->fillField(".admin__field[data-index=price] input", "99.99"); // stepKey: fillProductPrice
		$I->selectOption("//*[@name='product[tax_class_id]']", "Taxable Goods"); // stepKey: selectProductStockClass
		$I->selectOption("[data-index='product-details'] select[name='product[quantity_and_stock_status][is_in_stock]']", "Out of Stock"); // stepKey: selectStockStatusInStock
		$I->selectOption("//select[@name='product[visibility]']", "Search"); // stepKey: selectVisibility
		$I->click("div[data-index='search-engine-optimization']"); // stepKey: clickAdminProductSEOSection
		$I->waitForPageLoad(30); // stepKey: clickAdminProductSEOSectionWaitForPageLoad
		$I->fillField("input[name='product[url_key]']", "virtual-product" . msq("updateVirtualProductRegularPrice99OutOfStock")); // stepKey: fillUrlKey
		$I->scrollToTopOfPage(); // stepKey: scrollToTopOfAdminProductFormSection
		$I->comment("Entering Action Group [clickSaveButton] AdminProductFormSaveButtonClickActionGroup");
		$I->click("#save-button"); // stepKey: clickSaveButtonClickSaveButton
		$I->waitForPageLoad(30); // stepKey: clickSaveButtonClickSaveButtonWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForProductSavedClickSaveButton
		$I->comment("Exiting Action Group [clickSaveButton] AdminProductFormSaveButtonClickActionGroup");
		$I->comment("Verify we see success message");
		$I->see("You saved the product.", "#messages"); // stepKey: seeAssertVirtualProductSaveSuccessMessage
		$I->comment("Search updated virtual product(from above step) in the grid");
		$I->comment("Entering Action Group [openProductCatalogPageToSearchUpdatedVirtualProduct] AdminProductCatalogPageOpenActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/"); // stepKey: openProductCatalogPageOpenProductCatalogPageToSearchUpdatedVirtualProduct
		$I->waitForPageLoad(30); // stepKey: waitForProductCatalogPageLoadOpenProductCatalogPageToSearchUpdatedVirtualProduct
		$I->comment("Exiting Action Group [openProductCatalogPageToSearchUpdatedVirtualProduct] AdminProductCatalogPageOpenActionGroup");
		$I->conditionalClick(".admin__data-grid-header .admin__data-grid-filters-current._show .action-clear", ".admin__data-grid-header .admin__data-grid-filters-current._show .action-clear", true); // stepKey: clickClearAll
		$I->waitForPageLoad(30); // stepKey: clickClearAllWaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: clickFiltersButton
		$I->fillField("input.admin__control-text[name='name']", "VirtualProduct" . msq("updateVirtualProductRegularPrice99OutOfStock")); // stepKey: fillVirtualProductNameInNameFilter
		$I->fillField("input.admin__control-text[name='sku']", "virtual_sku" . msq("updateVirtualProductRegularPrice99OutOfStock")); // stepKey: fillVirtualProductSku
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersButton
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersButtonWaitForPageLoad
		$I->click(".data-row:nth-of-type(1)"); // stepKey: clickFirstRowToVerifyUpdatedVirtualProductVisibleInGrid
		$I->waitForPageLoad(30); // stepKey: clickFirstRowToVerifyUpdatedVirtualProductVisibleInGridWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitUntilVirtualProductPageIsOpened
		$I->comment("Verify customer see updated virtual product with regular price in the product form page");
		$I->seeInField(".admin__field[data-index=name] input", "VirtualProduct" . msq("updateVirtualProductRegularPrice99OutOfStock")); // stepKey: seeProductName
		$I->seeInField(".admin__field[data-index=sku] input", "virtual_sku" . msq("updateVirtualProductRegularPrice99OutOfStock")); // stepKey: seeProductSku
		$I->seeInField(".admin__field[data-index=price] input", "99.99"); // stepKey: seeProductPrice
		$I->seeInField("//*[@name='product[tax_class_id]']", "Taxable Goods"); // stepKey: seeProductTaxClass
		$I->seeInField("select[name='product[quantity_and_stock_status][is_in_stock]']", "Out of Stock"); // stepKey: seeProductStockStatus
		$I->waitForPageLoad(30); // stepKey: seeProductStockStatusWaitForPageLoad
		$I->seeInField("//select[@name='product[visibility]']", "Search"); // stepKey: seeVisibility
		$I->scrollTo("div[data-index='search-engine-optimization']", 0, -80); // stepKey: scrollToAdminProductSEOSection1
		$I->waitForPageLoad(30); // stepKey: scrollToAdminProductSEOSection1WaitForPageLoad
		$I->click("div[data-index='search-engine-optimization']"); // stepKey: clickAdminProductSEOSection1
		$I->waitForPageLoad(30); // stepKey: clickAdminProductSEOSection1WaitForPageLoad
		$I->seeInField("input[name='product[url_key]']", "virtual-product" . msq("updateVirtualProductRegularPrice99OutOfStock")); // stepKey: seeUrlKey
		$I->comment("Verify customer see updated virtual product on storefront page by url key");
		$I->amOnPage("/virtual-product" . msq("updateVirtualProductRegularPrice99OutOfStock") . ".html"); // stepKey: goToProductPage
		$I->waitForPageLoad(30); // stepKey: waitForStorefrontProductPageLoad
		$I->see("VirtualProduct" . msq("updateVirtualProductRegularPrice99OutOfStock"), ".base"); // stepKey: seeVirtualProductNameOnStoreFrontPage
		$I->see("99.99", "div.price-box.price-final_price"); // stepKey: seeVirtualProductPriceOnStoreFrontPage
		$I->comment("Entering Action Group [seeVirtualProductSku] StorefrontAssertProductSkuOnProductPageActionGroup");
		$I->see("virtual_sku" . msq("updateVirtualProductRegularPrice99OutOfStock"), ".product.attribute.sku>.value"); // stepKey: seeProductSkuSeeVirtualProductSku
		$I->comment("Exiting Action Group [seeVirtualProductSku] StorefrontAssertProductSkuOnProductPageActionGroup");
		$productStockAvailableStatus = $I->grabTextFrom(".stock[title=Availability]>span"); // stepKey: productStockAvailableStatus
		$I->assertEquals("OUT OF STOCK", $productStockAvailableStatus); // stepKey: assertStockAvailableOnProductPage
		$productPriceAmount = $I->grabTextFrom("div.price-box.price-final_price"); // stepKey: productPriceAmount
		$I->assertEquals("$99.99", $productPriceAmount); // stepKey: assertOldPriceTextOnProductPage
		$I->comment("Verify customer don't see updated virtual product link on magento storefront page");
		$I->amOnPage("/virtual-product" . msq("updateVirtualProductRegularPrice99OutOfStock") . ".html"); // stepKey: goToMagentoStorefrontPage
		$I->waitForPageLoad(30); // stepKey: waitForStoreFrontProductPageLoad
		$I->comment("Entering Action Group [fillVirtualProductName] StorefrontCheckQuickSearchStringActionGroup");
		$I->fillField("#search", "virtual_sku" . msq("updateVirtualProductRegularPrice99OutOfStock")); // stepKey: fillInputFillVirtualProductName
		$I->submitForm("#search", []); // stepKey: submitQuickSearchFillVirtualProductName
		$I->seeInCurrentUrl("/catalogsearch/result/"); // stepKey: checkUrlFillVirtualProductName
		$I->dontSeeInCurrentUrl("form_key="); // stepKey: checkUrlFormKeyFillVirtualProductName
		$I->seeInTitle("Search results for: 'virtual_sku" . msq("updateVirtualProductRegularPrice99OutOfStock") . "'"); // stepKey: assertQuickSearchTitleFillVirtualProductName
		$I->see("Search results for: 'virtual_sku" . msq("updateVirtualProductRegularPrice99OutOfStock") . "'", ".page-title span"); // stepKey: assertQuickSearchNameFillVirtualProductName
		$I->comment("Exiting Action Group [fillVirtualProductName] StorefrontCheckQuickSearchStringActionGroup");
		$I->comment("Comment is added to preserve the step key for backward compatibility");
		$I->comment("Comment is added to preserve the step key for backward compatibility");
		$I->comment("Comment is added to preserve the step key for backward compatibility");
		$I->comment("Entering Action Group [dontSeeVirtualProductLinkOnStorefrontPage] AssertStorefrontProductNameIsNotOnProductMainPageActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForTheProductPageToLoadDontSeeVirtualProductLinkOnStorefrontPage
		$I->dontSee("VirtualProduct" . msq("updateVirtualProductRegularPrice99OutOfStock"), ".product-item-name"); // stepKey: dontSeeProductNameDontSeeVirtualProductLinkOnStorefrontPage
		$I->comment("Exiting Action Group [dontSeeVirtualProductLinkOnStorefrontPage] AssertStorefrontProductNameIsNotOnProductMainPageActionGroup");
		$I->comment("Verify customer don't see updated virtual product link on category page");
		$I->amOnPage("/" . $I->retrieveEntityField('initialCategoryEntity', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: openCategoryPage
		$I->waitForPageLoad(30); // stepKey: waitForCategoryPageLoad
		$I->dontSee("VirtualProduct" . msq("updateVirtualProductRegularPrice99OutOfStock"), "a.product-item-link"); // stepKey: dontSeeVirtualProductLinkOnCategoryPage
		$I->waitForPageLoad(30); // stepKey: dontSeeVirtualProductLinkOnCategoryPageWaitForPageLoad
	}
}
