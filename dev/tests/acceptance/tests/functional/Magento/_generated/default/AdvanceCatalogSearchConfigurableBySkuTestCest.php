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
 * @Title("MC-144: Guest customer should be able to advance search configurable product with product sku")
 * @Description("Guest customer should be able to advance search configurable product with product sku<h3>Test files</h3>app/code/Magento/ConfigurableProduct/Test/Mftf/Test/AdvanceCatalogSearchConfigurableTest/AdvanceCatalogSearchConfigurableBySkuTest.xml<br>")
 * @TestCaseId("MC-144")
 * @group ConfigurableProduct
 */
class AdvanceCatalogSearchConfigurableBySkuTestCest
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
		$I->createEntity("product", "hook", "ApiConfigurableProductWithDescriptionUnderscoredSku", [], []); // stepKey: product
		$I->comment("TODO: Move configurable product creation to an actionGroup when MQE-697 is fixed");
		$I->createEntity("productAttributeHandle", "hook", "productDropDownAttribute", [], []); // stepKey: productAttributeHandle
		$I->createEntity("productAttributeOption1Handle", "hook", "productAttributeOption1", ["productAttributeHandle"], []); // stepKey: productAttributeOption1Handle
		$I->createEntity("productAttributeOption2Handle", "hook", "productAttributeOption2", ["productAttributeHandle"], []); // stepKey: productAttributeOption2Handle
		$I->createEntity("addToAttributeSetHandle", "hook", "AddToDefaultSet", ["productAttributeHandle"], []); // stepKey: addToAttributeSetHandle
		$I->getEntity("getAttributeOption1Handle", "hook", "ProductAttributeOptionGetter", ["productAttributeHandle"], null, 1); // stepKey: getAttributeOption1Handle
		$I->getEntity("getAttributeOption2Handle", "hook", "ProductAttributeOptionGetter", ["productAttributeHandle"], null, 2); // stepKey: getAttributeOption2Handle
		$I->createEntity("childProductHandle1", "hook", "SimpleOne", ["productAttributeHandle", "getAttributeOption1Handle"], []); // stepKey: childProductHandle1
		$I->createEntity("childProductHandle2", "hook", "SimpleOne", ["productAttributeHandle", "getAttributeOption2Handle"], []); // stepKey: childProductHandle2
		$I->createEntity("configProductOptionHandle", "hook", "ConfigurableProductTwoOptions", ["product", "productAttributeHandle", "getAttributeOption1Handle", "getAttributeOption2Handle"], []); // stepKey: configProductOptionHandle
		$I->createEntity("configProductHandle1", "hook", "ConfigurableProductAddChild", ["product", "childProductHandle1"], []); // stepKey: configProductHandle1
		$I->createEntity("configProductHandle2", "hook", "ConfigurableProductAddChild", ["product", "childProductHandle2"], []); // stepKey: configProductHandle2
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->deleteEntity("simple1Handle", "hook"); // stepKey: deleteSimple1
		$I->deleteEntity("simple2Handle", "hook"); // stepKey: deleteSimple2
		$I->deleteEntity("childProductHandle1", "hook"); // stepKey: deleteChildProduct1
		$I->deleteEntity("childProductHandle2", "hook"); // stepKey: deleteChildProduct2
		$I->deleteEntity("product", "hook"); // stepKey: delete
		$I->deleteEntity("productAttributeHandle", "hook"); // stepKey: deleteProductDropDownAttribute
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
	 * @Stories({"Advanced Catalog Product Search for all product types"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdvanceCatalogSearchConfigurableBySkuTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [reindex] CliIndexerReindexActionGroup");
		$reindexSpecifiedIndexersReindex = $I->magentoCLI("indexer:reindex", 60, "cataloginventory_stock catalog_product_price"); // stepKey: reindexSpecifiedIndexersReindex
		$I->comment($reindexSpecifiedIndexersReindex);
		$I->comment("Exiting Action Group [reindex] CliIndexerReindexActionGroup");
		$I->comment("Entering Action Group [flushCache] CliCacheFlushActionGroup");
		$flushSpecifiedCacheFlushCache = $I->magentoCLI("cache:flush", 60, ""); // stepKey: flushSpecifiedCacheFlushCache
		$I->comment($flushSpecifiedCacheFlushCache);
		$I->comment("Exiting Action Group [flushCache] CliCacheFlushActionGroup");
		$I->comment("Entering Action Group [GoToStoreViewAdvancedCatalogSearchActionGroup] GoToStoreViewAdvancedCatalogSearchActionGroup");
		$I->amOnPage("/catalogsearch/advanced/"); // stepKey: GoToStoreViewAdvancedCatalogSearchActionGroupGoToStoreViewAdvancedCatalogSearchActionGroup
		$I->waitForPageLoad(90); // stepKey: waitForPageLoadGoToStoreViewAdvancedCatalogSearchActionGroup
		$I->comment("Exiting Action Group [GoToStoreViewAdvancedCatalogSearchActionGroup] GoToStoreViewAdvancedCatalogSearchActionGroup");
		$I->comment("Entering Action Group [search] StorefrontAdvancedCatalogSearchByProductSkuActionGroup");
		$I->fillField("#sku", $I->retrieveEntityField('product', 'sku', 'test')); // stepKey: fillSearch
		$I->click("//*[@id='form-validate']//button[@type='submit']"); // stepKey: clickSubmitSearch
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadSearch
		$I->comment("Exiting Action Group [search] StorefrontAdvancedCatalogSearchByProductSkuActionGroup");
		$I->comment("Entering Action Group [StorefrontCheckAdvancedSearchResult] StorefrontCheckAdvancedSearchResultActionGroup");
		$I->seeInCurrentUrl("/catalogsearch/advanced/result"); // stepKey: checkUrlStorefrontCheckAdvancedSearchResult
		$I->seeInTitle("Advanced Search Results"); // stepKey: assertAdvancedSearchTitleStorefrontCheckAdvancedSearchResult
		$I->see("Catalog Advanced Search", ".page-title span"); // stepKey: assertAdvancedSearchNameStorefrontCheckAdvancedSearchResult
		$I->comment("Exiting Action Group [StorefrontCheckAdvancedSearchResult] StorefrontCheckAdvancedSearchResultActionGroup");
		$I->see("1 item", ".search.found>strong"); // stepKey: see
		$I->see($I->retrieveEntityField('product', 'name', 'test'), ".product.name.product-item-name>a"); // stepKey: seeProductName
	}
}
