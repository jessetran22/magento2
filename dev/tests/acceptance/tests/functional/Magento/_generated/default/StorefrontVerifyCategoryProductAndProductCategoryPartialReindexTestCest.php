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
 * @Title("MC-11386: Verify Category Product and Product Category partial reindex")
 * @Description("Verify that Merchant Developer can use console commands to perform partial reindex for Category Products, Product Categories, and Catalog Search<h3>Test files</h3>app/code/Magento/Catalog/Test/Mftf/Test/StorefrontVerifyCategoryProductAndProductCategoryPartialReindexTest.xml<br>")
 * @TestCaseId("MC-11386")
 * @group catalog
 * @group indexer
 */
class StorefrontVerifyCategoryProductAndProductCategoryPartialReindexTestCest
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
		$I->comment("Change \"Category Products\", \"Product Categories\" and \"Catalog Search\" indexers to \"Update by Schedule\" mode");
		$setIndexerMode = $I->magentoCLI("indexer:set-mode", 60, "schedule catalog_category_product catalog_product_category catalogsearch_fulltext"); // stepKey: setIndexerMode
		$I->comment($setIndexerMode);
		$I->comment("Create categories K, L, M, N with different nesting in the tree and Anchor = Yes/No");
		$I->comment("Category K is an anchor category");
		$I->createEntity("categoryK", "hook", "_defaultCategory", [], []); // stepKey: categoryK
		$I->comment("Category L is a non-anchor subcategory of category K");
		$I->createEntity("categoryL", "hook", "SubCategoryNonAnchor", ["categoryK"], []); // stepKey: categoryL
		$I->comment("Category M is a subcategory of category L");
		$I->createEntity("categoryM", "hook", "SubCategoryWithParent", ["categoryL"], []); // stepKey: categoryM
		$I->comment("Category N is a subcategory of category K");
		$I->createEntity("categoryN", "hook", "SubCategoryWithParent", ["categoryK"], []); // stepKey: categoryN
		$I->comment("Create different Products with different settings, assign to categories:");
		$I->comment("Product A in 0 categories, i.e. not assigned to any category");
		$I->createEntity("productA", "hook", "SimpleProduct2", [], []); // stepKey: productA
		$I->comment("Product B in 1 category M");
		$I->createEntity("productB", "hook", "SimpleProduct3", ["categoryM"], []); // stepKey: productB
		$I->comment("Product C in 2 categories M and N");
		$I->createEntity("productC", "hook", "SimpleProduct2", [], []); // stepKey: productC
		$I->createEntity("assignCategoryMToProductC", "hook", "AssignProductToCategory", ["categoryM", "productC"], []); // stepKey: assignCategoryMToProductC
		$I->createEntity("assignCategoryNToProductC", "hook", "AssignProductToCategory", ["categoryN", "productC"], []); // stepKey: assignCategoryNToProductC
		$reindexInvalidatedIndices = $I->magentoCron("index", 90); // stepKey: reindexInvalidatedIndices
		$I->comment($reindexInvalidatedIndices);
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Change indexers to \"Update on Save\" mode");
		$setRealtimeMode = $I->magentoCLI("indexer:set-mode", 60, "realtime"); // stepKey: setRealtimeMode
		$I->comment($setRealtimeMode);
		$I->comment("Delete data");
		$I->deleteEntity("productA", "hook"); // stepKey: deleteProductA
		$I->deleteEntity("productB", "hook"); // stepKey: deleteProductB
		$I->deleteEntity("productC", "hook"); // stepKey: deleteProductC
		$I->deleteEntity("categoryN", "hook"); // stepKey: deleteCategoryN
		$I->deleteEntity("categoryM", "hook"); // stepKey: deleteCategoryM
		$I->deleteEntity("categoryL", "hook"); // stepKey: deleteCategoryL
		$I->deleteEntity("categoryK", "hook"); // stepKey: deleteCategoryK
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
	 * @Features({"Catalog"})
	 * @Stories({"Product Categories Indexer"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StorefrontVerifyCategoryProductAndProductCategoryPartialReindexTest(AcceptanceTester $I)
	{
		$I->comment("Open categories K, L, M, N on Storefront");
		$I->comment("Category K contains only Products B & C");
		$I->amOnPage("/" . $I->retrieveEntityField('categoryK', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: onCategoryK
		$I->see($I->retrieveEntityField('productB', 'name', 'test'), ".product-item-name"); // stepKey: seeProductBOnCategoryK
		$I->see($I->retrieveEntityField('productC', 'name', 'test'), ".product-item-name"); // stepKey: seeProductCOnCategoryK
		$I->dontSee($I->retrieveEntityField('productA', 'name', 'test'), ".product-item-name"); // stepKey: dontSeeProductAOnCategoryK
		$I->comment("Category L contains no Products");
		$I->amOnPage("/" . $I->retrieveEntityField('categoryK', 'custom_attributes[url_key]', 'test') . "/" . $I->retrieveEntityField('categoryL', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: onCategoryL
		$I->see("We can't find products matching the selection.", ".message.info.empty>div"); // stepKey: seeMessage
		$I->dontSeeElement(".product-item-name"); // stepKey: dontseeProducts
		$I->comment("Category M contains only Products B & C");
		$I->amOnPage("/" . $I->retrieveEntityField('categoryK', 'custom_attributes[url_key]', 'test') . "/" . $I->retrieveEntityField('categoryL', 'custom_attributes[url_key]', 'test') . "/" . $I->retrieveEntityField('categoryM', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: onCategoryM
		$I->see($I->retrieveEntityField('productB', 'name', 'test'), ".product-item-name"); // stepKey: seeProductBOnCategoryM
		$I->see($I->retrieveEntityField('productC', 'name', 'test'), ".product-item-name"); // stepKey: seeProductCOnCategoryM
		$I->dontSee($I->retrieveEntityField('productA', 'name', 'test'), ".product-item-name"); // stepKey: dontSeeProductAOnCategoryM
		$I->comment("Category N contains only Product C");
		$I->amOnPage("/" . $I->retrieveEntityField('categoryK', 'custom_attributes[url_key]', 'test') . "/" . $I->retrieveEntityField('categoryN', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: onCategoryN
		$I->see($I->retrieveEntityField('productC', 'name', 'test'), ".product-item-name"); // stepKey: seeProductCOnCategoryN
		$I->dontSee($I->retrieveEntityField('productA', 'name', 'test'), ".product-item-name"); // stepKey: dontSeeProductAOnCategoryN
		$I->dontSee($I->retrieveEntityField('productB', 'name', 'test'), ".product-item-name"); // stepKey: dontSeeProductBOnCategoryN
		$I->comment("Assign category K to Product A");
		$I->createEntity("assignCategoryKToProductA", "test", "AssignProductToCategory", ["categoryK", "productA"], []); // stepKey: assignCategoryKToProductA
		$I->comment("Unassign category M from Product B");
		$I->deleteEntityByUrl("/V1/categories/" . $I->retrieveEntityField('categoryM', 'id', 'test') . "/products/" . $I->retrieveEntityField('productB', 'sku', 'test')); // stepKey: unassignCategoryMFromProductB
		$I->comment("Assign category L to Product C");
		$I->createEntity("assignCategoryLToProductC", "test", "AssignProductToCategory", ["categoryL", "productC"], []); // stepKey: assignCategoryLToProductC
		$I->comment("Open categories K, L, M, N on Storefront in order to make sure that new assignments are not applied yet");
		$I->comment("Category K contains only Products B & C");
		$I->amOnPage("/" . $I->retrieveEntityField('categoryK', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: amOnCategoryK
		$I->see($I->retrieveEntityField('productB', 'name', 'test'), ".product-item-name"); // stepKey: seeProductBCategoryK
		$I->see($I->retrieveEntityField('productC', 'name', 'test'), ".product-item-name"); // stepKey: seeProductCCategoryK
		$I->dontSee($I->retrieveEntityField('productA', 'name', 'test'), ".product-item-name"); // stepKey: dontSeeProductACategoryN
		$I->comment("Category L contains no Products");
		$I->amOnPage("/" . $I->retrieveEntityField('categoryK', 'custom_attributes[url_key]', 'test') . "/" . $I->retrieveEntityField('categoryL', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: amOnCategoryL
		$I->see("We can't find products matching the selection.", ".message.info.empty>div"); // stepKey: seeEmptyMessage
		$I->dontSeeElement(".product-item-name"); // stepKey: dontseeProduct
		$I->comment("Category M contains only Products B & C");
		$I->amOnPage("/" . $I->retrieveEntityField('categoryK', 'custom_attributes[url_key]', 'test') . "/" . $I->retrieveEntityField('categoryL', 'custom_attributes[url_key]', 'test') . "/" . $I->retrieveEntityField('categoryM', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: amOnCategoryM
		$I->see($I->retrieveEntityField('productB', 'name', 'test'), ".product-item-name"); // stepKey: seeProductBCategoryM
		$I->see($I->retrieveEntityField('productC', 'name', 'test'), ".product-item-name"); // stepKey: seeProductCCategoryM
		$I->dontSee($I->retrieveEntityField('productA', 'name', 'test'), ".product-item-name"); // stepKey: dontSeeProductAInCategoryM
		$I->comment("Category N contains only Product C");
		$I->amOnPage("/" . $I->retrieveEntityField('categoryK', 'custom_attributes[url_key]', 'test') . "/" . $I->retrieveEntityField('categoryN', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: amOnCategoryN
		$I->see($I->retrieveEntityField('productC', 'name', 'test'), ".product-item-name"); // stepKey: seeProductInCategoryN
		$I->dontSee($I->retrieveEntityField('productA', 'name', 'test'), ".product-item-name"); // stepKey: dontSeeProductAInCategoryN
		$I->dontSee($I->retrieveEntityField('productB', 'name', 'test'), ".product-item-name"); // stepKey: dontSeeProductBInCategoryN
		$I->comment("Run cron");
		$runCronIndex = $I->magentoCron("index", 90); // stepKey: runCronIndex
		$I->comment($runCronIndex);
		$I->comment("Open categories K, L, M, N on Storefront in order to make sure that new assignments are applied");
		$I->comment("Category K contains only Products A, C");
		$I->amOnPage("/" . $I->retrieveEntityField('categoryK', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: storefrontCategoryK
		$I->see($I->retrieveEntityField('productA', 'name', 'test'), ".product-item-name"); // stepKey: seeProductAOnCategoryK
		$I->see($I->retrieveEntityField('productC', 'name', 'test'), ".product-item-name"); // stepKey: seeCategoryKWithProductC
		$I->dontSee($I->retrieveEntityField('productB', 'name', 'test'), ".product-item-name"); // stepKey: dontSeeCategoryKWithProductB
		$I->comment("Category L contains only Product C");
		$I->amOnPage("/" . $I->retrieveEntityField('categoryK', 'custom_attributes[url_key]', 'test') . "/" . $I->retrieveEntityField('categoryL', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: storefrontCategoryL
		$I->see($I->retrieveEntityField('productC', 'name', 'test'), ".product-item-name"); // stepKey: seeCategoryLWithProductC
		$I->dontSee($I->retrieveEntityField('productA', 'name', 'test'), ".product-item-name"); // stepKey: dontSeeCategoryLWithProductA
		$I->dontSee($I->retrieveEntityField('productB', 'name', 'test'), ".product-item-name"); // stepKey: dontSeeCategoryLWithProductB
		$I->comment("Category M contains only Product C");
		$I->amOnPage("/" . $I->retrieveEntityField('categoryK', 'custom_attributes[url_key]', 'test') . "/" . $I->retrieveEntityField('categoryL', 'custom_attributes[url_key]', 'test') . "/" . $I->retrieveEntityField('categoryM', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: storefrontCategoryM
		$I->waitForPageLoad(30); // stepKey: waitForStorefrontCategoryM
		$I->see($I->retrieveEntityField('productC', 'name', 'test'), ".product-item-name"); // stepKey: seeCategoryMAndProductC
		$I->dontSee($I->retrieveEntityField('productA', 'name', 'test'), ".product-item-name"); // stepKey: dontSeeCategoryMAndProductA
		$I->dontSee($I->retrieveEntityField('productB', 'name', 'test'), ".product-item-name"); // stepKey: dontSeeCategoryMAndProductB
		$I->comment("Category N contains only Product C");
		$I->amOnPage("/" . $I->retrieveEntityField('categoryK', 'custom_attributes[url_key]', 'test') . "/" . $I->retrieveEntityField('categoryN', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: storefrontCategoryN
		$I->see($I->retrieveEntityField('productC', 'name', 'test'), ".product-item-name"); // stepKey: seeProductCAndCategoryN
		$I->dontSee($I->retrieveEntityField('productA', 'name', 'test'), ".product-item-name"); // stepKey: dontSeeProductAAndCategoryN
		$I->dontSee($I->retrieveEntityField('productB', 'name', 'test'), ".product-item-name"); // stepKey: dontSeeProductBAndCategoryN
		$I->comment("Remove Product A assignment for category K");
		$I->deleteEntityByUrl("/V1/categories/" . $I->retrieveEntityField('categoryK', 'id', 'test') . "/products/" . $I->retrieveEntityField('productA', 'sku', 'test')); // stepKey: unassignCategoryKFromProductA
		$I->comment("Remove Product C assignment for category L");
		$I->deleteEntityByUrl("/V1/categories/" . $I->retrieveEntityField('categoryL', 'id', 'test') . "/products/" . $I->retrieveEntityField('productC', 'sku', 'test')); // stepKey: unassignCategoryLFromProductC
		$I->comment("Add Product B assignment for category N");
		$I->createEntity("assignCategoryNToProductB", "test", "AssignProductToCategory", ["categoryN", "productB"], []); // stepKey: assignCategoryNToProductB
		$I->comment("Open categories K, L, M, N on Storefront in order to make sure that new assignments are not applied yet");
		$I->comment("Category K contains only Products A, C");
		$I->amOnPage("/" . $I->retrieveEntityField('categoryK', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: onStorefrontCategoryK
		$I->see($I->retrieveEntityField('productA', 'name', 'test'), ".product-item-name"); // stepKey: seeProductAWithCategoryK
		$I->see($I->retrieveEntityField('productC', 'name', 'test'), ".product-item-name"); // stepKey: seeProductC
		$I->dontSee($I->retrieveEntityField('productB', 'name', 'test'), ".product-item-name"); // stepKey: dontSeeProductB
		$I->comment("Category L contains only Product C");
		$I->amOnPage("/" . $I->retrieveEntityField('categoryK', 'custom_attributes[url_key]', 'test') . "/" . $I->retrieveEntityField('categoryL', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: onStorefrontCategoryL
		$I->see($I->retrieveEntityField('productC', 'name', 'test'), ".product-item-name"); // stepKey: seeCategoryLAndProductC
		$I->dontSee($I->retrieveEntityField('productA', 'name', 'test'), ".product-item-name"); // stepKey: dontSeeCategoryLAndProductA
		$I->dontSee($I->retrieveEntityField('productB', 'name', 'test'), ".product-item-name"); // stepKey: dontSeeCategoryLAndProductB
		$I->comment("Category M contains only Product C");
		$I->amOnPage("/" . $I->retrieveEntityField('categoryK', 'custom_attributes[url_key]', 'test') . "/" . $I->retrieveEntityField('categoryL', 'custom_attributes[url_key]', 'test') . "/" . $I->retrieveEntityField('categoryM', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: onStorefrontCategoryM
		$I->see($I->retrieveEntityField('productC', 'name', 'test'), ".product-item-name"); // stepKey: seeCategoryMWithProductC
		$I->dontSee($I->retrieveEntityField('productA', 'name', 'test'), ".product-item-name"); // stepKey: dontSeeCategoryMWithProductA
		$I->dontSee($I->retrieveEntityField('productB', 'name', 'test'), ".product-item-name"); // stepKey: dontSeeCategoryMWithProductB
		$I->comment("Category N contains only Product C");
		$I->amOnPage("/" . $I->retrieveEntityField('categoryK', 'custom_attributes[url_key]', 'test') . "/" . $I->retrieveEntityField('categoryN', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: onStorefrontCategoryN
		$I->see($I->retrieveEntityField('productC', 'name', 'test'), ".product-item-name"); // stepKey: productCOnCategoryN
		$I->dontSee($I->retrieveEntityField('productA', 'name', 'test'), ".product-item-name"); // stepKey: dontSeeProductAOnTheCategoryN
		$I->dontSee($I->retrieveEntityField('productB', 'name', 'test'), ".product-item-name"); // stepKey: dontSeeProductBOnTheCategoryN
		$I->comment("Run Cron once to reindex product changes");
		$runCronIndex2 = $I->magentoCron("index", 90); // stepKey: runCronIndex2
		$I->comment($runCronIndex2);
		$I->comment("Open categories K, L, M, N on Storefront in order to make sure that new assignments are applied");
		$I->comment("Category K contains only Products B & C");
		$I->amOnPage("/" . $I->retrieveEntityField('categoryK', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: onFrontendCategoryK
		$I->see($I->retrieveEntityField('productB', 'name', 'test'), ".product-item-name"); // stepKey: productBOnCategoryK
		$I->see($I->retrieveEntityField('productC', 'name', 'test'), ".product-item-name"); // stepKey: productCOnCategoryK
		$I->dontSee($I->retrieveEntityField('productA', 'name', 'test'), ".product-item-name"); // stepKey: dontSeeProductAOnTheCategoryK
		$I->comment("Category L contains no Products");
		$I->amOnPage("/" . $I->retrieveEntityField('categoryK', 'custom_attributes[url_key]', 'test') . "/" . $I->retrieveEntityField('categoryL', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: onFrontendCategoryL
		$I->see("We can't find products matching the selection.", ".message.info.empty>div"); // stepKey: noProductsMessage
		$I->dontSeeElement(".product-item-name"); // stepKey: dontSeeProductsOnCategoryL
		$I->comment("Category M contains only Product C");
		$I->amOnPage("/" . $I->retrieveEntityField('categoryK', 'custom_attributes[url_key]', 'test') . "/" . $I->retrieveEntityField('categoryL', 'custom_attributes[url_key]', 'test') . "/" . $I->retrieveEntityField('categoryM', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: onFrontendCategoryM
		$I->see($I->retrieveEntityField('productC', 'name', 'test'), ".product-item-name"); // stepKey: seeCategoryMPageAndProductC
		$I->dontSee($I->retrieveEntityField('productA', 'name', 'test'), ".product-item-name"); // stepKey: dontSeeCategoryMPageAndProductA
		$I->dontSee($I->retrieveEntityField('productB', 'name', 'test'), ".product-item-name"); // stepKey: dontSeeCategoryMPageAndProductB
		$I->comment("Category N contains only Products B and C");
		$I->amOnPage("/" . $I->retrieveEntityField('categoryK', 'custom_attributes[url_key]', 'test') . "/" . $I->retrieveEntityField('categoryN', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: onFrontendCategoryN
		$I->see($I->retrieveEntityField('productB', 'name', 'test'), ".product-item-name"); // stepKey: seeProductBAndCategoryN
		$I->see($I->retrieveEntityField('productC', 'name', 'test'), ".product-item-name"); // stepKey: seeProductCCategoryN
		$I->dontSee($I->retrieveEntityField('productA', 'name', 'test'), ".product-item-name"); // stepKey: dontSeeProductAWithCategoryN
	}
}
