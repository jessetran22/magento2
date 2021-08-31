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
 * @Title("MC-146: Guest customer should be able to advance search Grouped product with product sku")
 * @Description("Guest customer should be able to advance search Grouped product with product sku<h3>Test files</h3>app/code/Magento/GroupedProduct/Test/Mftf/Test/AdvanceCatalogSearchGroupedProductTest/AdvanceCatalogSearchGroupedProductBySkuTest.xml<br>")
 * @TestCaseId("MC-146")
 * @group GroupedProduct
 */
class AdvanceCatalogSearchGroupedProductBySkuTestCest
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
		$I->createEntity("simple1", "hook", "ApiProductWithDescription", [], []); // stepKey: simple1
		$I->createEntity("simple2", "hook", "ApiProductWithDescription", [], []); // stepKey: simple2
		$I->createEntity("product", "hook", "ApiGroupedProductAndUnderscoredSku", [], []); // stepKey: product
		$I->createEntity("addProductOne", "hook", "OneSimpleProductLink", ["product", "simple1"], []); // stepKey: addProductOne
		$I->updateEntity("addProductOne", "hook", "OneMoreSimpleProductLink",["product", "simple2"]); // stepKey: addProductTwo
		$I->comment("Adding the comment to replace CliIndexerReindexActionGroup action group ('indexer:reindex' commands) for preserving Backward Compatibility");
		$I->comment("Entering Action Group [flushCache] CliCacheFlushActionGroup");
		$flushSpecifiedCacheFlushCache = $I->magentoCLI("cache:flush", 60, ""); // stepKey: flushSpecifiedCacheFlushCache
		$I->comment($flushSpecifiedCacheFlushCache);
		$I->comment("Exiting Action Group [flushCache] CliCacheFlushActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->deleteEntity("simple1", "hook"); // stepKey: deleteSimple1
		$I->deleteEntity("simple2", "hook"); // stepKey: deleteSimple2
		$I->deleteEntity("product", "hook"); // stepKey: delete
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
	 * @Features({"GroupedProduct"})
	 * @Stories({"Advanced Catalog Product Search for all product types"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdvanceCatalogSearchGroupedProductBySkuTest(AcceptanceTester $I)
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
