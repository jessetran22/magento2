<?php
namespace Magento\AcceptanceTest\_SearchEngineElasticsearchSuite\Backend;

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
 * @Title("MC-31745: Check Advanced Search on ElasticSearch")
 * @Description("Check Advanced Search on ElasticSearch<h3>Test files</h3>app/code/Magento/Elasticsearch/Test/Mftf/Test/StorefrontCheckAdvancedSearchOnElasticSearchTest.xml<br>")
 * @TestCaseId("MC-31745")
 * @group SearchEngineElasticsearch
 * @group configurableProduct
 * @group catalog_search
 */
class StorefrontCheckAdvancedSearchOnElasticSearchTestCest
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
        $this->helperContainer->create("Magento\Rule\Test\Mftf\Helper\RuleHelper");
    }
	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _before(AcceptanceTester $I)
	{
		$I->comment("Delete all product if exists");
		$I->comment("Entering Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdminWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin
		$I->comment("Exiting Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->comment("Entering Action Group [navigateToProductIndexPage] AdminOpenProductIndexPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: goToProductIndexPageNavigateToProductIndexPage
		$I->waitForPageLoad(30); // stepKey: waitForProductIndexPageLoadNavigateToProductIndexPage
		$I->comment("Exiting Action Group [navigateToProductIndexPage] AdminOpenProductIndexPageActionGroup");
		$I->comment("Entering Action Group [deleteAllProducts] DeleteProductsIfTheyExistActionGroup");
		$I->conditionalClick("div[data-role='grid-wrapper'] th.data-grid-multicheck-cell button.action-multicheck-toggle", "table.data-grid tr.data-row:first-of-type", true); // stepKey: openMulticheckDropdownDeleteAllProducts
		$I->conditionalClick("//div[@data-role='grid-wrapper']//th[contains(@class, data-grid-multicheck-cell)]//li//span[text() = 'Select All']", "table.data-grid tr.data-row:first-of-type", true); // stepKey: selectAllProductInFilteredGridDeleteAllProducts
		$I->click("div.admin__data-grid-header-row.row div.action-select-wrap button.action-select"); // stepKey: clickActionDropdownDeleteAllProducts
		$I->waitForPageLoad(30); // stepKey: clickActionDropdownDeleteAllProductsWaitForPageLoad
		$I->click("//div[contains(@class,'admin__data-grid-header-row') and contains(@class, 'row')]//div[contains(@class, 'action-select-wrap')]//ul/li/span[text() = 'Delete']"); // stepKey: clickDeleteActionDeleteAllProducts
		$I->waitForPageLoad(30); // stepKey: clickDeleteActionDeleteAllProductsWaitForPageLoad
		$I->waitForElementVisible(".modal-popup.confirm button.action-accept", 30); // stepKey: waitForModalPopUpDeleteAllProducts
		$I->waitForPageLoad(60); // stepKey: waitForModalPopUpDeleteAllProductsWaitForPageLoad
		$I->click(".modal-popup.confirm button.action-accept"); // stepKey: confirmProductDeleteDeleteAllProducts
		$I->waitForPageLoad(60); // stepKey: confirmProductDeleteDeleteAllProductsWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForGridLoadDeleteAllProducts
		$I->comment("Exiting Action Group [deleteAllProducts] DeleteProductsIfTheyExistActionGroup");
		$I->comment("Entering Action Group [createConfigurableProduct] CreateApiConfigurableProductWithDescriptionActionGroup");
		$I->comment("Create the configurable product based on the data in the /data folder");
		$createConfigProductCreateConfigurableProductFields['name'] = "Product A";
		$I->createEntity("createConfigProductCreateConfigurableProduct", "hook", "ApiConfigurableProductWithDescription", [], $createConfigProductCreateConfigurableProductFields); // stepKey: createConfigProductCreateConfigurableProduct
		$I->comment("Create attribute with 2 options to be used in children products");
		$I->createEntity("createConfigProductAttributeCreateConfigurableProduct", "hook", "productAttributeWithTwoOptions", [], []); // stepKey: createConfigProductAttributeCreateConfigurableProduct
		$I->createEntity("createConfigProductAttributeOption1CreateConfigurableProduct", "hook", "productAttributeOption1", ["createConfigProductAttributeCreateConfigurableProduct"], []); // stepKey: createConfigProductAttributeOption1CreateConfigurableProduct
		$I->createEntity("createConfigProductAttributeOption2CreateConfigurableProduct", "hook", "productAttributeOption2", ["createConfigProductAttributeCreateConfigurableProduct"], []); // stepKey: createConfigProductAttributeOption2CreateConfigurableProduct
		$I->createEntity("addAttributeToAttributeSetCreateConfigurableProduct", "hook", "AddToDefaultSet", ["createConfigProductAttributeCreateConfigurableProduct"], []); // stepKey: addAttributeToAttributeSetCreateConfigurableProduct
		$I->getEntity("getConfigAttributeOption1CreateConfigurableProduct", "hook", "ProductAttributeOptionGetter", ["createConfigProductAttributeCreateConfigurableProduct"], null, 1); // stepKey: getConfigAttributeOption1CreateConfigurableProduct
		$I->getEntity("getConfigAttributeOption2CreateConfigurableProduct", "hook", "ProductAttributeOptionGetter", ["createConfigProductAttributeCreateConfigurableProduct"], null, 2); // stepKey: getConfigAttributeOption2CreateConfigurableProduct
		$I->comment("Create the 2 children that will be a part of the configurable product");
		$I->createEntity("createConfigChildProduct1CreateConfigurableProduct", "hook", "ApiSimpleOne", ["createConfigProductAttributeCreateConfigurableProduct", "getConfigAttributeOption1CreateConfigurableProduct"], []); // stepKey: createConfigChildProduct1CreateConfigurableProduct
		$I->createEntity("createConfigChildProduct2CreateConfigurableProduct", "hook", "ApiSimpleTwo", ["createConfigProductAttributeCreateConfigurableProduct", "getConfigAttributeOption2CreateConfigurableProduct"], []); // stepKey: createConfigChildProduct2CreateConfigurableProduct
		$I->comment("Assign the two products to the configurable product");
		$I->createEntity("createConfigProductOptionCreateConfigurableProduct", "hook", "ConfigurableProductTwoOptions", ["createConfigProductCreateConfigurableProduct", "createConfigProductAttributeCreateConfigurableProduct", "getConfigAttributeOption1CreateConfigurableProduct", "getConfigAttributeOption2CreateConfigurableProduct"], []); // stepKey: createConfigProductOptionCreateConfigurableProduct
		$I->createEntity("createConfigProductAddChild1CreateConfigurableProduct", "hook", "ConfigurableProductAddChild", ["createConfigProductCreateConfigurableProduct", "createConfigChildProduct1CreateConfigurableProduct"], []); // stepKey: createConfigProductAddChild1CreateConfigurableProduct
		$I->createEntity("createConfigProductAddChild2CreateConfigurableProduct", "hook", "ConfigurableProductAddChild", ["createConfigProductCreateConfigurableProduct", "createConfigChildProduct2CreateConfigurableProduct"], []); // stepKey: createConfigProductAddChild2CreateConfigurableProduct
		$I->comment("Replacement action. Create the configurable product via API.");
		$I->comment("Exiting Action Group [createConfigurableProduct] CreateApiConfigurableProductWithDescriptionActionGroup");
		$I->comment("Entering Action Group [createConfigurableProductTwo] CreateApiConfigurableProductWithDescriptionActionGroup");
		$I->comment("Create the configurable product based on the data in the /data folder");
		$createConfigProductCreateConfigurableProductTwoFields['name'] = "Product1234";
		$I->createEntity("createConfigProductCreateConfigurableProductTwo", "hook", "ApiConfigurableProductWithDescription", [], $createConfigProductCreateConfigurableProductTwoFields); // stepKey: createConfigProductCreateConfigurableProductTwo
		$I->comment("Create attribute with 2 options to be used in children products");
		$I->createEntity("createConfigProductAttributeCreateConfigurableProductTwo", "hook", "productAttributeWithTwoOptions", [], []); // stepKey: createConfigProductAttributeCreateConfigurableProductTwo
		$I->createEntity("createConfigProductAttributeOption1CreateConfigurableProductTwo", "hook", "productAttributeOption1", ["createConfigProductAttributeCreateConfigurableProductTwo"], []); // stepKey: createConfigProductAttributeOption1CreateConfigurableProductTwo
		$I->createEntity("createConfigProductAttributeOption2CreateConfigurableProductTwo", "hook", "productAttributeOption2", ["createConfigProductAttributeCreateConfigurableProductTwo"], []); // stepKey: createConfigProductAttributeOption2CreateConfigurableProductTwo
		$I->createEntity("addAttributeToAttributeSetCreateConfigurableProductTwo", "hook", "AddToDefaultSet", ["createConfigProductAttributeCreateConfigurableProductTwo"], []); // stepKey: addAttributeToAttributeSetCreateConfigurableProductTwo
		$I->getEntity("getConfigAttributeOption1CreateConfigurableProductTwo", "hook", "ProductAttributeOptionGetter", ["createConfigProductAttributeCreateConfigurableProductTwo"], null, 1); // stepKey: getConfigAttributeOption1CreateConfigurableProductTwo
		$I->getEntity("getConfigAttributeOption2CreateConfigurableProductTwo", "hook", "ProductAttributeOptionGetter", ["createConfigProductAttributeCreateConfigurableProductTwo"], null, 2); // stepKey: getConfigAttributeOption2CreateConfigurableProductTwo
		$I->comment("Create the 2 children that will be a part of the configurable product");
		$I->createEntity("createConfigChildProduct1CreateConfigurableProductTwo", "hook", "ApiSimpleOne", ["createConfigProductAttributeCreateConfigurableProductTwo", "getConfigAttributeOption1CreateConfigurableProductTwo"], []); // stepKey: createConfigChildProduct1CreateConfigurableProductTwo
		$I->createEntity("createConfigChildProduct2CreateConfigurableProductTwo", "hook", "ApiSimpleTwo", ["createConfigProductAttributeCreateConfigurableProductTwo", "getConfigAttributeOption2CreateConfigurableProductTwo"], []); // stepKey: createConfigChildProduct2CreateConfigurableProductTwo
		$I->comment("Assign the two products to the configurable product");
		$I->createEntity("createConfigProductOptionCreateConfigurableProductTwo", "hook", "ConfigurableProductTwoOptions", ["createConfigProductCreateConfigurableProductTwo", "createConfigProductAttributeCreateConfigurableProductTwo", "getConfigAttributeOption1CreateConfigurableProductTwo", "getConfigAttributeOption2CreateConfigurableProductTwo"], []); // stepKey: createConfigProductOptionCreateConfigurableProductTwo
		$I->createEntity("createConfigProductAddChild1CreateConfigurableProductTwo", "hook", "ConfigurableProductAddChild", ["createConfigProductCreateConfigurableProductTwo", "createConfigChildProduct1CreateConfigurableProductTwo"], []); // stepKey: createConfigProductAddChild1CreateConfigurableProductTwo
		$I->createEntity("createConfigProductAddChild2CreateConfigurableProductTwo", "hook", "ConfigurableProductAddChild", ["createConfigProductCreateConfigurableProductTwo", "createConfigChildProduct2CreateConfigurableProductTwo"], []); // stepKey: createConfigProductAddChild2CreateConfigurableProductTwo
		$I->comment("Replacement action. Create the configurable product via API.");
		$I->comment("Exiting Action Group [createConfigurableProductTwo] CreateApiConfigurableProductWithDescriptionActionGroup");
		$I->comment("Reindex invalidated indices after product attribute has been created/deleted");
		$reindexInvalidatedIndices = $I->magentoCron("index", 90); // stepKey: reindexInvalidatedIndices
		$I->comment($reindexInvalidatedIndices);
		$I->comment("Adding the comment to replace CliCacheFlushActionGroup action group ('cache:flush' command) for preserving Backward Compatibility");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Delete configurable products data");
		$I->deleteEntity("createConfigChildProduct1CreateConfigurableProduct", "hook"); // stepKey: deleteConfigChildProduct1
		$I->deleteEntity("createConfigChildProduct2CreateConfigurableProduct", "hook"); // stepKey: deleteConfigChildProduct2
		$I->deleteEntity("createConfigProductCreateConfigurableProduct", "hook"); // stepKey: deleteConfigProduct
		$I->deleteEntity("createConfigProductAttributeCreateConfigurableProduct", "hook"); // stepKey: deleteConfigProductAttribute
		$I->deleteEntity("createConfigChildProduct1CreateConfigurableProductTwo", "hook"); // stepKey: deleteConfigChildProduct1ForSecondProduct
		$I->deleteEntity("createConfigChildProduct2CreateConfigurableProductTwo", "hook"); // stepKey: deleteConfigChildProduct2ForSecondProduct
		$I->deleteEntity("createConfigProductCreateConfigurableProductTwo", "hook"); // stepKey: deleteConfigProductTwo
		$I->deleteEntity("createConfigProductAttributeCreateConfigurableProductTwo", "hook"); // stepKey: deleteConfigProductAttributeForSecondProduct
		$I->comment("Reindex invalidated indices after product attribute has been created/deleted");
		$reindexInvalidatedIndices = $I->magentoCron("index", 90); // stepKey: reindexInvalidatedIndices
		$I->comment($reindexInvalidatedIndices);
		$I->comment("Entering Action Group [logoutFromAdmin] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogoutFromAdmin
		$I->comment("Exiting Action Group [logoutFromAdmin] AdminLogoutActionGroup");
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
	 * @Features({"Elasticsearch"})
	 * @Stories({"Storefront Search"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StorefrontCheckAdvancedSearchOnElasticSearchTest(AcceptanceTester $I)
	{
		$I->comment("Navigate to Frontend");
		$I->comment("Entering Action Group [goToStorefront] StorefrontOpenHomePageActionGroup");
		$I->amOnPage("/"); // stepKey: goToStorefrontPageGoToStorefront
		$I->waitForPageLoad(30); // stepKey: waitForStorefrontPageLoadGoToStorefront
		$I->comment("Exiting Action Group [goToStorefront] StorefrontOpenHomePageActionGroup");
		$I->comment("Click \"Advanced Search\"");
		$I->comment("Entering Action Group [openAdvancedSearch] StorefrontOpenAdvancedSearchActionGroup");
		$I->click("//footer//ul//li//a[text()='Advanced Search']"); // stepKey: clickAdvancedSearchLinkOpenAdvancedSearch
		$I->seeInCurrentUrl("/catalogsearch/advanced/"); // stepKey: checkUrlOpenAdvancedSearch
		$I->seeInTitle("Advanced Search"); // stepKey: assertAdvancedSearchTitle1OpenAdvancedSearch
		$I->see("Advanced Search", ".page-title span"); // stepKey: assertAdvancedSearchTitle2OpenAdvancedSearch
		$I->comment("Exiting Action Group [openAdvancedSearch] StorefrontOpenAdvancedSearchActionGroup");
		$I->comment("Fill Configurable name in to field. Click \"Search\" button and assert product present");
		$I->comment("Entering Action Group [searchConfigurableProductByName] StorefrontFillFormAdvancedSearchActionGroup");
		$I->fillField("#name", $I->retrieveEntityField('createConfigProductCreateConfigurableProduct', 'name', 'test')); // stepKey: fillNameSearchConfigurableProductByName
		$I->fillField("#sku", ""); // stepKey: fillSkuSearchConfigurableProductByName
		$I->fillField("#description", ""); // stepKey: fillDescriptionSearchConfigurableProductByName
		$I->fillField("#short_description", ""); // stepKey: fillShortDescriptionSearchConfigurableProductByName
		$I->fillField("#price", ""); // stepKey: fillPriceFromSearchConfigurableProductByName
		$I->fillField("#price_to", ""); // stepKey: fillPriceToSearchConfigurableProductByName
		$I->scrollTo("//*[@id='form-validate']//button[@type='submit']"); // stepKey: scrollToSubmitButtonSearchConfigurableProductByName
		$I->click("//*[@id='form-validate']//button[@type='submit']"); // stepKey: clickSubmitSearchConfigurableProductByName
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadSearchConfigurableProductByName
		$I->comment("Exiting Action Group [searchConfigurableProductByName] StorefrontFillFormAdvancedSearchActionGroup");
		$I->comment("Entering Action Group [storefrontCheckAdvancedSearchResult] StorefrontCheckAdvancedSearchResultActionGroup");
		$I->seeInCurrentUrl("/catalogsearch/advanced/result"); // stepKey: checkUrlStorefrontCheckAdvancedSearchResult
		$I->seeInTitle("Advanced Search Results"); // stepKey: assertAdvancedSearchTitleStorefrontCheckAdvancedSearchResult
		$I->see("Catalog Advanced Search", ".page-title span"); // stepKey: assertAdvancedSearchNameStorefrontCheckAdvancedSearchResult
		$I->comment("Exiting Action Group [storefrontCheckAdvancedSearchResult] StorefrontCheckAdvancedSearchResultActionGroup");
		$I->comment("Entering Action Group [assertConfigurableProductIsPresentOnCategoryPage] AssertStorefrontProductIsPresentOnCategoryPageActionGroup");
		$I->waitForElementVisible("//main//li//a[contains(text(), '" . $I->retrieveEntityField('createConfigProductCreateConfigurableProduct', 'name', 'test') . "')]", 30); // stepKey: assertProductNameAssertConfigurableProductIsPresentOnCategoryPage
		$I->comment("Exiting Action Group [assertConfigurableProductIsPresentOnCategoryPage] AssertStorefrontProductIsPresentOnCategoryPageActionGroup");
		$I->comment("Entering Action Group [goToStoreViewAdvancedCatalogSearch] StorefrontOpenAdvancedSearchActionGroup");
		$I->click("//footer//ul//li//a[text()='Advanced Search']"); // stepKey: clickAdvancedSearchLinkGoToStoreViewAdvancedCatalogSearch
		$I->seeInCurrentUrl("/catalogsearch/advanced/"); // stepKey: checkUrlGoToStoreViewAdvancedCatalogSearch
		$I->seeInTitle("Advanced Search"); // stepKey: assertAdvancedSearchTitle1GoToStoreViewAdvancedCatalogSearch
		$I->see("Advanced Search", ".page-title span"); // stepKey: assertAdvancedSearchTitle2GoToStoreViewAdvancedCatalogSearch
		$I->comment("Exiting Action Group [goToStoreViewAdvancedCatalogSearch] StorefrontOpenAdvancedSearchActionGroup");
		$I->comment("Fill Configurable Two name in to field. Click \"Search\" button and assert product present");
		$I->comment("Entering Action Group [searchConfigurableProductTwoByName] StorefrontFillFormAdvancedSearchActionGroup");
		$I->fillField("#name", $I->retrieveEntityField('createConfigProductCreateConfigurableProductTwo', 'name', 'test')); // stepKey: fillNameSearchConfigurableProductTwoByName
		$I->fillField("#sku", ""); // stepKey: fillSkuSearchConfigurableProductTwoByName
		$I->fillField("#description", ""); // stepKey: fillDescriptionSearchConfigurableProductTwoByName
		$I->fillField("#short_description", ""); // stepKey: fillShortDescriptionSearchConfigurableProductTwoByName
		$I->fillField("#price", ""); // stepKey: fillPriceFromSearchConfigurableProductTwoByName
		$I->fillField("#price_to", ""); // stepKey: fillPriceToSearchConfigurableProductTwoByName
		$I->scrollTo("//*[@id='form-validate']//button[@type='submit']"); // stepKey: scrollToSubmitButtonSearchConfigurableProductTwoByName
		$I->click("//*[@id='form-validate']//button[@type='submit']"); // stepKey: clickSubmitSearchConfigurableProductTwoByName
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadSearchConfigurableProductTwoByName
		$I->comment("Exiting Action Group [searchConfigurableProductTwoByName] StorefrontFillFormAdvancedSearchActionGroup");
		$I->comment("Entering Action Group [checkResultSearchConfigurableProductByName] StorefrontCheckAdvancedSearchResultActionGroup");
		$I->seeInCurrentUrl("/catalogsearch/advanced/result"); // stepKey: checkUrlCheckResultSearchConfigurableProductByName
		$I->seeInTitle("Advanced Search Results"); // stepKey: assertAdvancedSearchTitleCheckResultSearchConfigurableProductByName
		$I->see("Catalog Advanced Search", ".page-title span"); // stepKey: assertAdvancedSearchNameCheckResultSearchConfigurableProductByName
		$I->comment("Exiting Action Group [checkResultSearchConfigurableProductByName] StorefrontCheckAdvancedSearchResultActionGroup");
		$I->comment("Entering Action Group [assertConfigurableProductTwoIsPresentOnCategoryPage] AssertStorefrontProductIsPresentOnCategoryPageActionGroup");
		$I->waitForElementVisible("//main//li//a[contains(text(), '" . $I->retrieveEntityField('createConfigProductCreateConfigurableProductTwo', 'name', 'test') . "')]", 30); // stepKey: assertProductNameAssertConfigurableProductTwoIsPresentOnCategoryPage
		$I->comment("Exiting Action Group [assertConfigurableProductTwoIsPresentOnCategoryPage] AssertStorefrontProductIsPresentOnCategoryPageActionGroup");
		$I->comment("Entering Action Group [goToAdvancedCatalogSearchPage] StorefrontOpenAdvancedSearchActionGroup");
		$I->click("//footer//ul//li//a[text()='Advanced Search']"); // stepKey: clickAdvancedSearchLinkGoToAdvancedCatalogSearchPage
		$I->seeInCurrentUrl("/catalogsearch/advanced/"); // stepKey: checkUrlGoToAdvancedCatalogSearchPage
		$I->seeInTitle("Advanced Search"); // stepKey: assertAdvancedSearchTitle1GoToAdvancedCatalogSearchPage
		$I->see("Advanced Search", ".page-title span"); // stepKey: assertAdvancedSearchTitle2GoToAdvancedCatalogSearchPage
		$I->comment("Exiting Action Group [goToAdvancedCatalogSearchPage] StorefrontOpenAdvancedSearchActionGroup");
		$I->comment("Fill Configurable partial name in to field. Click \"Search\" button and assert product present");
		$I->comment("Entering Action Group [searchConfigurableProductByPartialName] StorefrontFillFormAdvancedSearchActionGroup");
		$I->fillField("#name", "Product"); // stepKey: fillNameSearchConfigurableProductByPartialName
		$I->fillField("#sku", ""); // stepKey: fillSkuSearchConfigurableProductByPartialName
		$I->fillField("#description", ""); // stepKey: fillDescriptionSearchConfigurableProductByPartialName
		$I->fillField("#short_description", ""); // stepKey: fillShortDescriptionSearchConfigurableProductByPartialName
		$I->fillField("#price", ""); // stepKey: fillPriceFromSearchConfigurableProductByPartialName
		$I->fillField("#price_to", ""); // stepKey: fillPriceToSearchConfigurableProductByPartialName
		$I->scrollTo("//*[@id='form-validate']//button[@type='submit']"); // stepKey: scrollToSubmitButtonSearchConfigurableProductByPartialName
		$I->click("//*[@id='form-validate']//button[@type='submit']"); // stepKey: clickSubmitSearchConfigurableProductByPartialName
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadSearchConfigurableProductByPartialName
		$I->comment("Exiting Action Group [searchConfigurableProductByPartialName] StorefrontFillFormAdvancedSearchActionGroup");
		$I->comment("Entering Action Group [checkResultSearchConfigurableProductByPartialName] StorefrontCheckAdvancedSearchResultActionGroup");
		$I->seeInCurrentUrl("/catalogsearch/advanced/result"); // stepKey: checkUrlCheckResultSearchConfigurableProductByPartialName
		$I->seeInTitle("Advanced Search Results"); // stepKey: assertAdvancedSearchTitleCheckResultSearchConfigurableProductByPartialName
		$I->see("Catalog Advanced Search", ".page-title span"); // stepKey: assertAdvancedSearchNameCheckResultSearchConfigurableProductByPartialName
		$I->comment("Exiting Action Group [checkResultSearchConfigurableProductByPartialName] StorefrontCheckAdvancedSearchResultActionGroup");
		$I->comment("Entering Action Group [assertConfigurableProductOneIsPresentAfterSearchByPartialName] AssertStorefrontProductIsPresentOnCategoryPageActionGroup");
		$I->waitForElementVisible("//main//li//a[contains(text(), '" . $I->retrieveEntityField('createConfigProductCreateConfigurableProduct', 'name', 'test') . "')]", 30); // stepKey: assertProductNameAssertConfigurableProductOneIsPresentAfterSearchByPartialName
		$I->comment("Exiting Action Group [assertConfigurableProductOneIsPresentAfterSearchByPartialName] AssertStorefrontProductIsPresentOnCategoryPageActionGroup");
		$I->comment("Entering Action Group [assertConfigurableProductTwoIsPresentAfterSearchByPartialName] AssertStorefrontProductIsPresentOnCategoryPageActionGroup");
		$I->waitForElementVisible("//main//li//a[contains(text(), '" . $I->retrieveEntityField('createConfigProductCreateConfigurableProductTwo', 'name', 'test') . "')]", 30); // stepKey: assertProductNameAssertConfigurableProductTwoIsPresentAfterSearchByPartialName
		$I->comment("Exiting Action Group [assertConfigurableProductTwoIsPresentAfterSearchByPartialName] AssertStorefrontProductIsPresentOnCategoryPageActionGroup");
		$I->comment("Entering Action Group [goToAdvancedSearchForSearchProductByDescription] StorefrontOpenAdvancedSearchActionGroup");
		$I->click("//footer//ul//li//a[text()='Advanced Search']"); // stepKey: clickAdvancedSearchLinkGoToAdvancedSearchForSearchProductByDescription
		$I->seeInCurrentUrl("/catalogsearch/advanced/"); // stepKey: checkUrlGoToAdvancedSearchForSearchProductByDescription
		$I->seeInTitle("Advanced Search"); // stepKey: assertAdvancedSearchTitle1GoToAdvancedSearchForSearchProductByDescription
		$I->see("Advanced Search", ".page-title span"); // stepKey: assertAdvancedSearchTitle2GoToAdvancedSearchForSearchProductByDescription
		$I->comment("Exiting Action Group [goToAdvancedSearchForSearchProductByDescription] StorefrontOpenAdvancedSearchActionGroup");
		$I->comment("Fill Configurable short description in to field. Click \"Search\" button and assert product present");
		$I->comment("Entering Action Group [searchConfigurableProductByDescription] StorefrontFillFormAdvancedSearchActionGroup");
		$I->fillField("#name", ""); // stepKey: fillNameSearchConfigurableProductByDescription
		$I->fillField("#sku", ""); // stepKey: fillSkuSearchConfigurableProductByDescription
		$I->fillField("#description", $I->retrieveEntityField('createConfigProductCreateConfigurableProduct', 'product[custom_attributes][0][value]', 'test')); // stepKey: fillDescriptionSearchConfigurableProductByDescription
		$I->fillField("#short_description", ""); // stepKey: fillShortDescriptionSearchConfigurableProductByDescription
		$I->fillField("#price", ""); // stepKey: fillPriceFromSearchConfigurableProductByDescription
		$I->fillField("#price_to", ""); // stepKey: fillPriceToSearchConfigurableProductByDescription
		$I->scrollTo("//*[@id='form-validate']//button[@type='submit']"); // stepKey: scrollToSubmitButtonSearchConfigurableProductByDescription
		$I->click("//*[@id='form-validate']//button[@type='submit']"); // stepKey: clickSubmitSearchConfigurableProductByDescription
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadSearchConfigurableProductByDescription
		$I->comment("Exiting Action Group [searchConfigurableProductByDescription] StorefrontFillFormAdvancedSearchActionGroup");
		$I->comment("Entering Action Group [storefrontCheckAdvancedSearchResultAfterSearchByDescription] StorefrontCheckAdvancedSearchResultActionGroup");
		$I->seeInCurrentUrl("/catalogsearch/advanced/result"); // stepKey: checkUrlStorefrontCheckAdvancedSearchResultAfterSearchByDescription
		$I->seeInTitle("Advanced Search Results"); // stepKey: assertAdvancedSearchTitleStorefrontCheckAdvancedSearchResultAfterSearchByDescription
		$I->see("Catalog Advanced Search", ".page-title span"); // stepKey: assertAdvancedSearchNameStorefrontCheckAdvancedSearchResultAfterSearchByDescription
		$I->comment("Exiting Action Group [storefrontCheckAdvancedSearchResultAfterSearchByDescription] StorefrontCheckAdvancedSearchResultActionGroup");
		$I->comment("Entering Action Group [assertConfigurableProductIsPresentAfterSearchByDescription] AssertStorefrontProductIsPresentOnCategoryPageActionGroup");
		$I->waitForElementVisible("//main//li//a[contains(text(), '" . $I->retrieveEntityField('createConfigProductCreateConfigurableProduct', 'name', 'test') . "')]", 30); // stepKey: assertProductNameAssertConfigurableProductIsPresentAfterSearchByDescription
		$I->comment("Exiting Action Group [assertConfigurableProductIsPresentAfterSearchByDescription] AssertStorefrontProductIsPresentOnCategoryPageActionGroup");
		$I->comment("Entering Action Group [goToAdvancedSearchForSearchProductByShortDescription] StorefrontOpenAdvancedSearchActionGroup");
		$I->click("//footer//ul//li//a[text()='Advanced Search']"); // stepKey: clickAdvancedSearchLinkGoToAdvancedSearchForSearchProductByShortDescription
		$I->seeInCurrentUrl("/catalogsearch/advanced/"); // stepKey: checkUrlGoToAdvancedSearchForSearchProductByShortDescription
		$I->seeInTitle("Advanced Search"); // stepKey: assertAdvancedSearchTitle1GoToAdvancedSearchForSearchProductByShortDescription
		$I->see("Advanced Search", ".page-title span"); // stepKey: assertAdvancedSearchTitle2GoToAdvancedSearchForSearchProductByShortDescription
		$I->comment("Exiting Action Group [goToAdvancedSearchForSearchProductByShortDescription] StorefrontOpenAdvancedSearchActionGroup");
		$I->comment("Fill Configurable short description in to field. Click \"Search\" button and assert product present");
		$I->comment("Entering Action Group [searchConfigurableProductByShortDescription] StorefrontFillFormAdvancedSearchActionGroup");
		$I->fillField("#name", ""); // stepKey: fillNameSearchConfigurableProductByShortDescription
		$I->fillField("#sku", ""); // stepKey: fillSkuSearchConfigurableProductByShortDescription
		$I->fillField("#description", ""); // stepKey: fillDescriptionSearchConfigurableProductByShortDescription
		$I->fillField("#short_description", $I->retrieveEntityField('createConfigProductCreateConfigurableProduct', 'product[custom_attributes][1][value]', 'test')); // stepKey: fillShortDescriptionSearchConfigurableProductByShortDescription
		$I->fillField("#price", ""); // stepKey: fillPriceFromSearchConfigurableProductByShortDescription
		$I->fillField("#price_to", ""); // stepKey: fillPriceToSearchConfigurableProductByShortDescription
		$I->scrollTo("//*[@id='form-validate']//button[@type='submit']"); // stepKey: scrollToSubmitButtonSearchConfigurableProductByShortDescription
		$I->click("//*[@id='form-validate']//button[@type='submit']"); // stepKey: clickSubmitSearchConfigurableProductByShortDescription
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadSearchConfigurableProductByShortDescription
		$I->comment("Exiting Action Group [searchConfigurableProductByShortDescription] StorefrontFillFormAdvancedSearchActionGroup");
		$I->comment("Entering Action Group [storefrontCheckAdvancedSearchResultAfterSearchByShortDescription] StorefrontCheckAdvancedSearchResultActionGroup");
		$I->seeInCurrentUrl("/catalogsearch/advanced/result"); // stepKey: checkUrlStorefrontCheckAdvancedSearchResultAfterSearchByShortDescription
		$I->seeInTitle("Advanced Search Results"); // stepKey: assertAdvancedSearchTitleStorefrontCheckAdvancedSearchResultAfterSearchByShortDescription
		$I->see("Catalog Advanced Search", ".page-title span"); // stepKey: assertAdvancedSearchNameStorefrontCheckAdvancedSearchResultAfterSearchByShortDescription
		$I->comment("Exiting Action Group [storefrontCheckAdvancedSearchResultAfterSearchByShortDescription] StorefrontCheckAdvancedSearchResultActionGroup");
		$I->comment("Entering Action Group [assertConfigurableProductIsPresentAfterSearchByShortDescription] AssertStorefrontProductIsPresentOnCategoryPageActionGroup");
		$I->waitForElementVisible("//main//li//a[contains(text(), '" . $I->retrieveEntityField('createConfigProductCreateConfigurableProduct', 'name', 'test') . "')]", 30); // stepKey: assertProductNameAssertConfigurableProductIsPresentAfterSearchByShortDescription
		$I->comment("Exiting Action Group [assertConfigurableProductIsPresentAfterSearchByShortDescription] AssertStorefrontProductIsPresentOnCategoryPageActionGroup");
		$I->comment("Entering Action Group [goToAdvancedSearchForSearchProductsByPrice] StorefrontOpenAdvancedSearchActionGroup");
		$I->click("//footer//ul//li//a[text()='Advanced Search']"); // stepKey: clickAdvancedSearchLinkGoToAdvancedSearchForSearchProductsByPrice
		$I->seeInCurrentUrl("/catalogsearch/advanced/"); // stepKey: checkUrlGoToAdvancedSearchForSearchProductsByPrice
		$I->seeInTitle("Advanced Search"); // stepKey: assertAdvancedSearchTitle1GoToAdvancedSearchForSearchProductsByPrice
		$I->see("Advanced Search", ".page-title span"); // stepKey: assertAdvancedSearchTitle2GoToAdvancedSearchForSearchProductsByPrice
		$I->comment("Exiting Action Group [goToAdvancedSearchForSearchProductsByPrice] StorefrontOpenAdvancedSearchActionGroup");
		$I->comment("Fill Configurable price in to fields. Click \"Search\" button and assert product present");
		$I->comment("Entering Action Group [searchConfigurableProductByPrice] StorefrontFillFormAdvancedSearchActionGroup");
		$I->fillField("#name", ""); // stepKey: fillNameSearchConfigurableProductByPrice
		$I->fillField("#sku", ""); // stepKey: fillSkuSearchConfigurableProductByPrice
		$I->fillField("#description", ""); // stepKey: fillDescriptionSearchConfigurableProductByPrice
		$I->fillField("#short_description", ""); // stepKey: fillShortDescriptionSearchConfigurableProductByPrice
		$I->fillField("#price", "40"); // stepKey: fillPriceFromSearchConfigurableProductByPrice
		$I->fillField("#price_to", "123"); // stepKey: fillPriceToSearchConfigurableProductByPrice
		$I->scrollTo("//*[@id='form-validate']//button[@type='submit']"); // stepKey: scrollToSubmitButtonSearchConfigurableProductByPrice
		$I->click("//*[@id='form-validate']//button[@type='submit']"); // stepKey: clickSubmitSearchConfigurableProductByPrice
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadSearchConfigurableProductByPrice
		$I->comment("Exiting Action Group [searchConfigurableProductByPrice] StorefrontFillFormAdvancedSearchActionGroup");
		$I->comment("Entering Action Group [storefrontCheckAdvancedSearchResultAfterSearchByPrice] StorefrontCheckAdvancedSearchResultActionGroup");
		$I->seeInCurrentUrl("/catalogsearch/advanced/result"); // stepKey: checkUrlStorefrontCheckAdvancedSearchResultAfterSearchByPrice
		$I->seeInTitle("Advanced Search Results"); // stepKey: assertAdvancedSearchTitleStorefrontCheckAdvancedSearchResultAfterSearchByPrice
		$I->see("Catalog Advanced Search", ".page-title span"); // stepKey: assertAdvancedSearchNameStorefrontCheckAdvancedSearchResultAfterSearchByPrice
		$I->comment("Exiting Action Group [storefrontCheckAdvancedSearchResultAfterSearchByPrice] StorefrontCheckAdvancedSearchResultActionGroup");
		$I->comment("Entering Action Group [assertConfigurableProductIsPresentAfterSearchByPrice] AssertStorefrontProductIsPresentOnCategoryPageActionGroup");
		$I->waitForElementVisible("//main//li//a[contains(text(), '" . $I->retrieveEntityField('createConfigProductCreateConfigurableProduct', 'name', 'test') . "')]", 30); // stepKey: assertProductNameAssertConfigurableProductIsPresentAfterSearchByPrice
		$I->comment("Exiting Action Group [assertConfigurableProductIsPresentAfterSearchByPrice] AssertStorefrontProductIsPresentOnCategoryPageActionGroup");
		$I->comment("Entering Action Group [assertConfigurableProductTwoIsPresentAfterSearchByPrice] AssertStorefrontProductIsPresentOnCategoryPageActionGroup");
		$I->waitForElementVisible("//main//li//a[contains(text(), '" . $I->retrieveEntityField('createConfigProductCreateConfigurableProductTwo', 'name', 'test') . "')]", 30); // stepKey: assertProductNameAssertConfigurableProductTwoIsPresentAfterSearchByPrice
		$I->comment("Exiting Action Group [assertConfigurableProductTwoIsPresentAfterSearchByPrice] AssertStorefrontProductIsPresentOnCategoryPageActionGroup");
		$I->comment("Entering Action Group [goToAdvancedCatalogSearchPageForSearchByDescriptionAndAttribute] StorefrontOpenAdvancedSearchActionGroup");
		$I->click("//footer//ul//li//a[text()='Advanced Search']"); // stepKey: clickAdvancedSearchLinkGoToAdvancedCatalogSearchPageForSearchByDescriptionAndAttribute
		$I->seeInCurrentUrl("/catalogsearch/advanced/"); // stepKey: checkUrlGoToAdvancedCatalogSearchPageForSearchByDescriptionAndAttribute
		$I->seeInTitle("Advanced Search"); // stepKey: assertAdvancedSearchTitle1GoToAdvancedCatalogSearchPageForSearchByDescriptionAndAttribute
		$I->see("Advanced Search", ".page-title span"); // stepKey: assertAdvancedSearchTitle2GoToAdvancedCatalogSearchPageForSearchByDescriptionAndAttribute
		$I->comment("Exiting Action Group [goToAdvancedCatalogSearchPageForSearchByDescriptionAndAttribute] StorefrontOpenAdvancedSearchActionGroup");
		$I->comment("Fill Configurable description in to field and select attribute. Click \"Search\" button and assert product present");
		$I->comment("Entering Action Group [searchConfigurableProductByDescriptionAndAttribute] StorefrontFillFormAdvancedSearchWithCustomDropDownAttributeActionGroup");
		$I->fillField("#name", ""); // stepKey: fillNameSearchConfigurableProductByDescriptionAndAttribute
		$I->fillField("#sku", ""); // stepKey: fillSkuSearchConfigurableProductByDescriptionAndAttribute
		$I->fillField("#description", $I->retrieveEntityField('createConfigProductCreateConfigurableProduct', 'product[custom_attributes][0][value]', 'test')); // stepKey: fillDescriptionSearchConfigurableProductByDescriptionAndAttribute
		$I->fillField("#short_description", ""); // stepKey: fillShortDescriptionSearchConfigurableProductByDescriptionAndAttribute
		$I->fillField("#price", ""); // stepKey: fillPriceFromSearchConfigurableProductByDescriptionAndAttribute
		$I->fillField("#price_to", ""); // stepKey: fillPriceToSearchConfigurableProductByDescriptionAndAttribute
		$I->scrollTo("//*[@id='form-validate']//button[@type='submit']"); // stepKey: scrollToSubmitButtonSearchConfigurableProductByDescriptionAndAttribute
		$I->selectOption("#" . $I->retrieveEntityField('createConfigProductAttributeCreateConfigurableProduct', 'attribute[attribute_code]', 'test'), $I->retrieveEntityField('createConfigProductAttributeOption1CreateConfigurableProduct', 'option[store_labels][0][label]', 'test')); // stepKey: selectOptionSearchConfigurableProductByDescriptionAndAttribute
		$I->click("//*[@id='form-validate']//button[@type='submit']"); // stepKey: clickSubmitSearchConfigurableProductByDescriptionAndAttribute
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadSearchConfigurableProductByDescriptionAndAttribute
		$I->comment("Exiting Action Group [searchConfigurableProductByDescriptionAndAttribute] StorefrontFillFormAdvancedSearchWithCustomDropDownAttributeActionGroup");
		$I->comment("Entering Action Group [storefrontCheckAdvancedSearchResultAfterSearchByDescriptionAndAttribute] StorefrontCheckAdvancedSearchResultActionGroup");
		$I->seeInCurrentUrl("/catalogsearch/advanced/result"); // stepKey: checkUrlStorefrontCheckAdvancedSearchResultAfterSearchByDescriptionAndAttribute
		$I->seeInTitle("Advanced Search Results"); // stepKey: assertAdvancedSearchTitleStorefrontCheckAdvancedSearchResultAfterSearchByDescriptionAndAttribute
		$I->see("Catalog Advanced Search", ".page-title span"); // stepKey: assertAdvancedSearchNameStorefrontCheckAdvancedSearchResultAfterSearchByDescriptionAndAttribute
		$I->comment("Exiting Action Group [storefrontCheckAdvancedSearchResultAfterSearchByDescriptionAndAttribute] StorefrontCheckAdvancedSearchResultActionGroup");
		$I->comment("Entering Action Group [assertConfigurableProductIsPresentAfterSearchByDescriptionAndAttribute] AssertStorefrontProductIsPresentOnCategoryPageActionGroup");
		$I->waitForElementVisible("//main//li//a[contains(text(), '" . $I->retrieveEntityField('createConfigProductCreateConfigurableProduct', 'name', 'test') . "')]", 30); // stepKey: assertProductNameAssertConfigurableProductIsPresentAfterSearchByDescriptionAndAttribute
		$I->comment("Exiting Action Group [assertConfigurableProductIsPresentAfterSearchByDescriptionAndAttribute] AssertStorefrontProductIsPresentOnCategoryPageActionGroup");
		$I->comment("Entering Action Group [goToAdvancedSearchForSearchProductByDescriptionAndShortDescription] StorefrontOpenAdvancedSearchActionGroup");
		$I->click("//footer//ul//li//a[text()='Advanced Search']"); // stepKey: clickAdvancedSearchLinkGoToAdvancedSearchForSearchProductByDescriptionAndShortDescription
		$I->seeInCurrentUrl("/catalogsearch/advanced/"); // stepKey: checkUrlGoToAdvancedSearchForSearchProductByDescriptionAndShortDescription
		$I->seeInTitle("Advanced Search"); // stepKey: assertAdvancedSearchTitle1GoToAdvancedSearchForSearchProductByDescriptionAndShortDescription
		$I->see("Advanced Search", ".page-title span"); // stepKey: assertAdvancedSearchTitle2GoToAdvancedSearchForSearchProductByDescriptionAndShortDescription
		$I->comment("Exiting Action Group [goToAdvancedSearchForSearchProductByDescriptionAndShortDescription] StorefrontOpenAdvancedSearchActionGroup");
		$I->comment("Fill Configurable description and short description in to fields. Click \"Search\" button and assert product present");
		$I->comment("Entering Action Group [searchConfigurableProductByDescriptionAndShortDescription] StorefrontFillFormAdvancedSearchActionGroup");
		$I->fillField("#name", ""); // stepKey: fillNameSearchConfigurableProductByDescriptionAndShortDescription
		$I->fillField("#sku", ""); // stepKey: fillSkuSearchConfigurableProductByDescriptionAndShortDescription
		$I->fillField("#description", $I->retrieveEntityField('createConfigProductCreateConfigurableProduct', 'product[custom_attributes][0][value]', 'test')); // stepKey: fillDescriptionSearchConfigurableProductByDescriptionAndShortDescription
		$I->fillField("#short_description", $I->retrieveEntityField('createConfigProductCreateConfigurableProduct', 'product[custom_attributes][1][value]', 'test')); // stepKey: fillShortDescriptionSearchConfigurableProductByDescriptionAndShortDescription
		$I->fillField("#price", ""); // stepKey: fillPriceFromSearchConfigurableProductByDescriptionAndShortDescription
		$I->fillField("#price_to", ""); // stepKey: fillPriceToSearchConfigurableProductByDescriptionAndShortDescription
		$I->scrollTo("//*[@id='form-validate']//button[@type='submit']"); // stepKey: scrollToSubmitButtonSearchConfigurableProductByDescriptionAndShortDescription
		$I->click("//*[@id='form-validate']//button[@type='submit']"); // stepKey: clickSubmitSearchConfigurableProductByDescriptionAndShortDescription
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadSearchConfigurableProductByDescriptionAndShortDescription
		$I->comment("Exiting Action Group [searchConfigurableProductByDescriptionAndShortDescription] StorefrontFillFormAdvancedSearchActionGroup");
		$I->comment("Entering Action Group [storefrontCheckAdvancedSearchResultAfterSearchByDescriptionAndShortDescription] StorefrontCheckAdvancedSearchResultActionGroup");
		$I->seeInCurrentUrl("/catalogsearch/advanced/result"); // stepKey: checkUrlStorefrontCheckAdvancedSearchResultAfterSearchByDescriptionAndShortDescription
		$I->seeInTitle("Advanced Search Results"); // stepKey: assertAdvancedSearchTitleStorefrontCheckAdvancedSearchResultAfterSearchByDescriptionAndShortDescription
		$I->see("Catalog Advanced Search", ".page-title span"); // stepKey: assertAdvancedSearchNameStorefrontCheckAdvancedSearchResultAfterSearchByDescriptionAndShortDescription
		$I->comment("Exiting Action Group [storefrontCheckAdvancedSearchResultAfterSearchByDescriptionAndShortDescription] StorefrontCheckAdvancedSearchResultActionGroup");
		$I->comment("Entering Action Group [assertConfigurableProductIsPresentAfterSearchByDescriptionAndShortDescription] AssertStorefrontProductIsPresentOnCategoryPageActionGroup");
		$I->waitForElementVisible("//main//li//a[contains(text(), '" . $I->retrieveEntityField('createConfigProductCreateConfigurableProduct', 'name', 'test') . "')]", 30); // stepKey: assertProductNameAssertConfigurableProductIsPresentAfterSearchByDescriptionAndShortDescription
		$I->comment("Exiting Action Group [assertConfigurableProductIsPresentAfterSearchByDescriptionAndShortDescription] AssertStorefrontProductIsPresentOnCategoryPageActionGroup");
	}
}
