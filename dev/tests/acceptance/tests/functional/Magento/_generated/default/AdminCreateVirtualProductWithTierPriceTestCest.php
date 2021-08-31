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
 * @Title("MC-6032: Create virtual product with tier price")
 * @Description("Test log in to Create virtual product and Create virtual product with tier price<h3>Test files</h3>app/code/Magento/Catalog/Test/Mftf/Test/AdminCreateVirtualProductWithTierPriceTest.xml<br>")
 * @TestCaseId("MC-6032")
 * @group catalog
 * @group mtf_migrated
 */
class AdminCreateVirtualProductWithTierPriceTestCest
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
		$I->createEntity("categoryEntity", "hook", "SimpleSubCategory", [], []); // stepKey: categoryEntity
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->deleteEntity("categoryEntity", "hook"); // stepKey: deleteSimpleSubCategory
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
	 * @Stories({"Create virtual product"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Features({"Catalog"})
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminCreateVirtualProductWithTierPriceTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [openProductCatalogPage] AdminProductCatalogPageOpenActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/"); // stepKey: openProductCatalogPageOpenProductCatalogPage
		$I->waitForPageLoad(30); // stepKey: waitForProductCatalogPageLoadOpenProductCatalogPage
		$I->comment("Exiting Action Group [openProductCatalogPage] AdminProductCatalogPageOpenActionGroup");
		$I->comment("Adding the comment to replace clickAddProductToggle action for preserving Backward Compatibility");
		$I->comment("Adding the comment to replace clickAddProductToggle action for preserving Backward Compatibility");
		$I->comment("Entering Action Group [clickVirtualProduct] AdminClickAddProductToggleAndSelectProductTypeActionGroup");
		$I->click(".action-toggle.primary.add"); // stepKey: clickAddProductDropdownClickVirtualProduct
		$I->waitForPageLoad(30); // stepKey: clickAddProductDropdownClickVirtualProductWaitForPageLoad
		$I->click(".item[data-ui-id='products-list-add-new-product-button-item-virtual']"); // stepKey: clickAddProductClickVirtualProduct
		$I->waitForPageLoad(30); // stepKey: waitForFormToLoadClickVirtualProduct
		$I->comment("Exiting Action Group [clickVirtualProduct] AdminClickAddProductToggleAndSelectProductTypeActionGroup");
		$I->comment("Create virtual product with tier price");
		$I->fillField(".admin__field[data-index=name] input", "VirtualProduct" . msq("virtualProductBigQty")); // stepKey: fillProductName
		$I->fillField(".admin__field[data-index=sku] input", "virtual_sku" . msq("virtualProductBigQty")); // stepKey: fillProductSku
		$I->fillField(".admin__field[data-index=price] input", "100.00"); // stepKey: fillProductPrice
		$I->click("button[data-index='advanced_pricing_button']"); // stepKey: clickAdvancedPricingLink
		$I->waitForPageLoad(30); // stepKey: clickAdvancedPricingLinkWaitForPageLoad
		$I->click("[data-action='add_new_row']"); // stepKey: clickCustomerGroupPriceAddButton
		$I->waitForPageLoad(30); // stepKey: clickCustomerGroupPriceAddButtonWaitForPageLoad
		$I->scrollTo("[name='product[tier_price][0][price_qty]']", 50, 0); // stepKey: scrollToProductTierPriceQuantityInputTextBox
		$I->fillField("[name='product[tier_price][0][price_qty]']", "2"); // stepKey: fillProductTierPriceQuantityInput
		$I->fillField("[name='product[tier_price][0][price]']", "90.00"); // stepKey: selectProductTierPriceFixedPrice
		$I->click(".product_form_product_form_advanced_pricing_modal button.action-primary"); // stepKey: clickDoneButton
		$I->waitForPageLoad(30); // stepKey: clickDoneButtonWaitForPageLoad
		$I->selectOption("//*[@name='product[tax_class_id]']", "None"); // stepKey: selectProductTaxClass
		$I->fillField(".admin__field[data-index=qty] input", "999"); // stepKey: fillProductQuantity
		$I->selectOption("[data-index='product-details'] select[name='product[quantity_and_stock_status][is_in_stock]']", "In Stock"); // stepKey: selectStockStatusInStock
		$I->click("div[data-index='category_ids']"); // stepKey: clickCategoriesDropDown
		$I->waitForPageLoad(30); // stepKey: clickCategoriesDropDownWaitForPageLoad
		$I->fillField("//*[@data-index='category_ids']//input[contains(@class, 'multiselect-search')]", $I->retrieveEntityField('categoryEntity', 'name', 'test')); // stepKey: fillSearchCategory
		$I->waitForPageLoad(30); // stepKey: fillSearchCategoryWaitForPageLoad
		$I->click("//*[@data-index='category_ids']//label[contains(., '" . $I->retrieveEntityField('categoryEntity', 'name', 'test') . "')]"); // stepKey: clickOnCategory
		$I->waitForPageLoad(30); // stepKey: clickOnCategoryWaitForPageLoad
		$I->comment("Entering Action Group [clickOnDoneAdvancedCategorySelect] AdminSubmitCategoriesPopupActionGroup");
		$I->click("//*[@data-index='category_ids']//button[@data-action='close-advanced-select']"); // stepKey: clickOnDoneButtonClickOnDoneAdvancedCategorySelect
		$I->waitForPageLoad(30); // stepKey: clickOnDoneButtonClickOnDoneAdvancedCategorySelectWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCategoryApplyClickOnDoneAdvancedCategorySelect
		$I->comment("Exiting Action Group [clickOnDoneAdvancedCategorySelect] AdminSubmitCategoriesPopupActionGroup");
		$I->selectOption("//select[@name='product[visibility]']", "Catalog, Search"); // stepKey: selectVisibility
		$I->click("div[data-index='search-engine-optimization']"); // stepKey: clickAdminProductSEOSection
		$I->waitForPageLoad(30); // stepKey: clickAdminProductSEOSectionWaitForPageLoad
		$I->fillField("input[name='product[url_key]']", "virtual-product" . msq("virtualProductBigQty")); // stepKey: fillUrlKey
		$I->scrollToTopOfPage(); // stepKey: scrollToTopOfAdminProductFormSection
		$I->comment("Entering Action Group [clickSaveButton] AdminProductFormSaveButtonClickActionGroup");
		$I->click("#save-button"); // stepKey: clickSaveButtonClickSaveButton
		$I->waitForPageLoad(30); // stepKey: clickSaveButtonClickSaveButtonWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForProductSavedClickSaveButton
		$I->comment("Exiting Action Group [clickSaveButton] AdminProductFormSaveButtonClickActionGroup");
		$I->comment("Verify we see success message");
		$I->see("You saved the product.", "#messages"); // stepKey: seeAssertVirtualProductSuccessMessage
		$I->comment("Entering Action Group [openProductCatalogPage1] AdminProductCatalogPageOpenActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/"); // stepKey: openProductCatalogPageOpenProductCatalogPage1
		$I->waitForPageLoad(30); // stepKey: waitForProductCatalogPageLoadOpenProductCatalogPage1
		$I->comment("Exiting Action Group [openProductCatalogPage1] AdminProductCatalogPageOpenActionGroup");
		$I->comment("Entering Action Group [searchProductGrid] SearchProductGridByKeywordActionGroup");
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersInitialSearchProductGrid
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersInitialSearchProductGridWaitForPageLoad
		$I->fillField("input#fulltext", "VirtualProduct" . msq("virtualProductBigQty")); // stepKey: fillKeywordSearchFieldSearchProductGrid
		$I->click(".data-grid-search-control-wrap button.action-submit"); // stepKey: clickKeywordSearchSearchProductGrid
		$I->waitForPageLoad(30); // stepKey: clickKeywordSearchSearchProductGridWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForProductSearchSearchProductGrid
		$I->comment("Exiting Action Group [searchProductGrid] SearchProductGridByKeywordActionGroup");
		$I->click(".data-row:nth-of-type(1)"); // stepKey: clickFirstRowToVerifyCreatedVirtualProduct
		$I->waitForPageLoad(30); // stepKey: clickFirstRowToVerifyCreatedVirtualProductWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitUntilProductIsOpened
		$I->comment("Verify we see created virtual product with tier price(from the above step) in the product form page");
		$I->seeInField(".admin__field[data-index=name] input", "VirtualProduct" . msq("virtualProductBigQty")); // stepKey: seeProductName
		$I->seeInField(".admin__field[data-index=sku] input", "virtual_sku" . msq("virtualProductBigQty")); // stepKey: seeProductSku
		$I->seeInField(".admin__field[data-index=price] input", "100.00"); // stepKey: seeProductPrice
		$I->click("button[data-index='advanced_pricing_button']"); // stepKey: clickAdvancedPricingLink1
		$I->waitForPageLoad(30); // stepKey: clickAdvancedPricingLink1WaitForPageLoad
		$I->seeInField("[name='product[tier_price][0][price_qty]']", "2"); // stepKey: seeProductTierPriceQuantityInput
		$I->seeInField("[name='product[tier_price][0][price]']", "90.00"); // stepKey: seeProductTierPriceFixedPrice
		$I->click(".product_form_product_form_advanced_pricing_modal button.action-close"); // stepKey: clickAdvancedPricingCloseButton
		$I->waitForPageLoad(30); // stepKey: clickAdvancedPricingCloseButtonWaitForPageLoad
		$I->seeInField("//*[@name='product[tax_class_id]']", "None"); // stepKey: seeProductTaxClass
		$I->seeInField(".admin__field[data-index=qty] input", "999"); // stepKey: seeProductQuantity
		$I->seeInField("select[name='product[quantity_and_stock_status][is_in_stock]']", "In Stock"); // stepKey: seeProductStockStatus
		$I->waitForPageLoad(30); // stepKey: seeProductStockStatusWaitForPageLoad
		$I->click("div[data-index='category_ids']"); // stepKey: clickCategoriesDropDownToVerify
		$I->waitForPageLoad(30); // stepKey: clickCategoriesDropDownToVerifyWaitForPageLoad
		$selectedCategories = $I->grabMultiple("//*[@data-index='container_category_ids']//*[contains(@class, '_selected')]"); // stepKey: selectedCategories
		$I->assertEquals([$I->retrieveEntityField('categoryEntity', 'name', 'test')], $selectedCategories); // stepKey: assertSelectedCategories
		$I->comment("Entering Action Group [clickOnDoneOnCategorySelect] AdminSubmitCategoriesPopupActionGroup");
		$I->click("//*[@data-index='category_ids']//button[@data-action='close-advanced-select']"); // stepKey: clickOnDoneButtonClickOnDoneOnCategorySelect
		$I->waitForPageLoad(30); // stepKey: clickOnDoneButtonClickOnDoneOnCategorySelectWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCategoryApplyClickOnDoneOnCategorySelect
		$I->comment("Exiting Action Group [clickOnDoneOnCategorySelect] AdminSubmitCategoriesPopupActionGroup");
		$I->seeInField("//select[@name='product[visibility]']", "Catalog, Search"); // stepKey: seeVisibility
		$I->scrollTo("div[data-index='search-engine-optimization']", 0, -80); // stepKey: scrollToAdminProductSEOSection1
		$I->waitForPageLoad(30); // stepKey: scrollToAdminProductSEOSection1WaitForPageLoad
		$I->click("div[data-index='search-engine-optimization']"); // stepKey: clickAdminProductSEOSection1
		$I->waitForPageLoad(30); // stepKey: clickAdminProductSEOSection1WaitForPageLoad
		$I->seeInField("input[name='product[url_key]']", "virtual-product" . msq("virtualProductBigQty")); // stepKey: seeUrlKey
		$I->comment("Verify customer see created virtual product on category page");
		$I->amOnPage("/" . $I->retrieveEntityField('categoryEntity', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: openCategoryPage
		$I->waitForPageLoad(30); // stepKey: waitForCategoryPageToLoad
		$I->see("VirtualProduct" . msq("virtualProductBigQty"), "a.product-item-link"); // stepKey: seeVirtualProductNameOnCategoryPage
		$I->waitForPageLoad(30); // stepKey: seeVirtualProductNameOnCategoryPageWaitForPageLoad
		$I->comment("Adding the comment to replace CliIndexerReindexActionGroup action group ('indexer:reindex' commands) for preserving Backward Compatibility");
		$I->comment("Adding the comment to replace CliCacheFlushActionGroup action group ('cache:flush' command) for preserving Backward Compatibility");
		$I->comment("Verify customer see created virtual product with tier price(from above step) on storefront page and is searchable by sku");
		$I->comment("Entering Action Group [goToHomePage] StorefrontOpenHomePageActionGroup");
		$I->amOnPage("/"); // stepKey: goToStorefrontPageGoToHomePage
		$I->waitForPageLoad(30); // stepKey: waitForStorefrontPageLoadGoToHomePage
		$I->comment("Exiting Action Group [goToHomePage] StorefrontOpenHomePageActionGroup");
		$I->comment("Entering Action Group [fillVirtualProductName] StorefrontCheckQuickSearchStringActionGroup");
		$I->fillField("#search", "virtual_sku" . msq("virtualProductBigQty")); // stepKey: fillInputFillVirtualProductName
		$I->submitForm("#search", []); // stepKey: submitQuickSearchFillVirtualProductName
		$I->seeInCurrentUrl("/catalogsearch/result/"); // stepKey: checkUrlFillVirtualProductName
		$I->dontSeeInCurrentUrl("form_key="); // stepKey: checkUrlFormKeyFillVirtualProductName
		$I->seeInTitle("Search results for: 'virtual_sku" . msq("virtualProductBigQty") . "'"); // stepKey: assertQuickSearchTitleFillVirtualProductName
		$I->see("Search results for: 'virtual_sku" . msq("virtualProductBigQty") . "'", ".page-title span"); // stepKey: assertQuickSearchNameFillVirtualProductName
		$I->comment("Exiting Action Group [fillVirtualProductName] StorefrontCheckQuickSearchStringActionGroup");
		$I->comment("Comment is added to preserve the step key for backward compatibility");
		$I->comment("Comment is added to preserve the step key for backward compatibility");
		$I->comment("Comment is added to preserve the step key for backward compatibility");
		$I->comment("Entering Action Group [seeVirtualProductName] StorefrontAssertProductNameOnProductMainPageActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForTheProductPageToLoadSeeVirtualProductName
		$I->see("VirtualProduct" . msq("virtualProductBigQty"), ".product-item-name"); // stepKey: seeProductNameSeeVirtualProductName
		$I->comment("Exiting Action Group [seeVirtualProductName] StorefrontAssertProductNameOnProductMainPageActionGroup");
		$tierPriceTextOnStorefrontPage = $I->grabTextFrom(".minimal-price-link > span"); // stepKey: tierPriceTextOnStorefrontPage
		$I->assertEquals("As low as $90.00", $tierPriceTextOnStorefrontPage); // stepKey: assertTierPriceTextOnCategoryPage
		$I->click("a[class='product-item-link']"); // stepKey: openSearchedProduct
		$I->waitForPageLoad(30); // stepKey: openSearchedProductWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForProductPageToBeLoaded
		$I->comment("Verify customer see product tier price on product page");
		$tierPriceText = $I->grabTextFrom(".prices-tier li[class='item']"); // stepKey: tierPriceText
		$I->assertEquals("Buy 2 for $90.00 each and save 10%", $tierPriceText); // stepKey: assertTierPriceTextOnProductPage
	}
}
