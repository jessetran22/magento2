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
 * @Title("MAGETWO-98644: Add Product that is Out of Stock product to Product Comparison")
 * @Description("Customer should be able to add Product that is Out Of Stock to the Product Comparison<h3>Test files</h3>app/code/Magento/Catalog/Test/Mftf/Test/AddOutOfStockProductToCompareListTest.xml<br>")
 * @TestCaseId("MAGETWO-98644")
 * @group Catalog
 */
class AddOutOfStockProductToCompareListTestCest
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
		$I->comment("Adding the comment for preserving Backward Compatibility");
		$setConfigShowOutOfStockFalse = $I->magentoCLI("config:set cataloginventory/options/show_out_of_stock 0", 60); // stepKey: setConfigShowOutOfStockFalse
		$I->comment($setConfigShowOutOfStockFalse);
		$I->comment("Adding the comment to replace CliCacheFlushActionGroup action group ('cache:flush' command) for preserving Backward Compatibility");
		$I->createEntity("category", "hook", "SimpleSubCategory", [], []); // stepKey: category
		$I->createEntity("product", "hook", "SimpleProduct4", ["category"], []); // stepKey: product
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$setConfigShowOutOfStockFalse = $I->magentoCLI("config:set cataloginventory/options/show_out_of_stock 0", 60); // stepKey: setConfigShowOutOfStockFalse
		$I->comment($setConfigShowOutOfStockFalse);
		$I->comment("Adding the comment to replace CliCacheFlushActionGroup action group ('cache:flush' command) for preserving Backward Compatibility");
		$I->deleteEntity("product", "hook"); // stepKey: deleteProduct
		$I->deleteEntity("category", "hook"); // stepKey: deleteCategory
		$I->comment("Adding the comment for preserving Backward Compatibility");
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
	 * @Stories({"Product Comparison for products Out of Stock"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AddOutOfStockProductToCompareListTest(AcceptanceTester $I)
	{
		$I->comment("Open product page | Comment is kept to preserve the step key for backward compatibility");
		$I->comment("Comment is added to preserve the step key for backward compatibility");
		$I->comment("Entering Action Group [waitForSimpleProductPage] StorefrontOpenProductPageActionGroup");
		$I->amOnPage("/" . $I->retrieveEntityField('product', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: openProductPageWaitForSimpleProductPage
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoadedWaitForSimpleProductPage
		$I->comment("Exiting Action Group [waitForSimpleProductPage] StorefrontOpenProductPageActionGroup");
		$I->comment("'Add to compare' link is not available | Comment is kept to preserve the step key for backward compatibility");
		$I->dontSeeElement("a.action.tocompare"); // stepKey: dontSeeAddToCompareLink
		$I->comment("Turn on 'out of stock' config | Comment is kept to preserve the step key for backward compatibility");
		$setConfigShowOutOfStockTrue = $I->magentoCLI("config:set cataloginventory/options/show_out_of_stock 1", 60); // stepKey: setConfigShowOutOfStockTrue
		$I->comment($setConfigShowOutOfStockTrue);
		$I->comment("Clear cache and reindex | Comment is kept to preserve the step key for backward compatibility");
		$I->comment("Entering Action Group [reindex] CliIndexerReindexActionGroup");
		$reindexSpecifiedIndexersReindex = $I->magentoCLI("indexer:reindex", 60, "catalog_product_price"); // stepKey: reindexSpecifiedIndexersReindex
		$I->comment($reindexSpecifiedIndexersReindex);
		$I->comment("Exiting Action Group [reindex] CliIndexerReindexActionGroup");
		$I->comment("Adding the comment to replace CliCacheFlushActionGroup action group ('cache:flush' command) for preserving Backward Compatibility");
		$I->comment("Open product page | Comment is kept to preserve the step key for backward compatibility");
		$I->comment("Comment is added to preserve the step key for backward compatibility");
		$I->comment("Comment is added to preserve the step key for backward compatibility");
		$I->comment("Entering Action Group [seeAddToCompareLink] StorefrontOpenProductPageActionGroup");
		$I->amOnPage("/" . $I->retrieveEntityField('product', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: openProductPageSeeAddToCompareLink
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoadedSeeAddToCompareLink
		$I->comment("Exiting Action Group [seeAddToCompareLink] StorefrontOpenProductPageActionGroup");
		$I->comment("Click on 'Add to Compare' link | Comment is kept to preserve the step key for backward compatibility");
		$I->comment("Comment is added to preserve the step key for backward compatibility");
		$I->comment("Comment is added to preserve the step key for backward compatibility");
		$I->comment("Assert success message | Comment is kept to preserve the step key for backward compatibility");
		$I->comment("Comment is added to preserve the step key for backward compatibility");
		$I->comment("Entering Action Group [assertSuccessMessage] StorefrontAddProductToCompareActionGroup");
		$I->click("a.action.tocompare"); // stepKey: clickAddToCompareAssertSuccessMessage
		$I->waitForElement("div.message-success.success.message", 30); // stepKey: waitForAddProductToCompareSuccessMessageAssertSuccessMessage
		$I->see("You added product " . $I->retrieveEntityField('product', 'name', 'test') . " to the comparison list.", "div.message-success.success.message"); // stepKey: assertAddProductToCompareSuccessMessageAssertSuccessMessage
		$I->comment("Exiting Action Group [assertSuccessMessage] StorefrontAddProductToCompareActionGroup");
		$I->comment("See product in the comparison list | Comment is kept to preserve the step key for backward compatibility");
		$I->comment("Entering Action Group [openCategoryPage] StorefrontGoToCategoryPageActionGroup");
		$I->amOnPage("/"); // stepKey: onFrontendOpenCategoryPage
		$I->waitForPageLoad(30); // stepKey: waitForStorefrontPageLoadOpenCategoryPage
		$I->click("//nav//a[span[contains(., '" . $I->retrieveEntityField('category', 'name', 'test') . "')]]"); // stepKey: toCategoryOpenCategoryPage
		$I->waitForPageLoad(30); // stepKey: toCategoryOpenCategoryPageWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCategoryPageOpenCategoryPage
		$I->comment("Exiting Action Group [openCategoryPage] StorefrontGoToCategoryPageActionGroup");
		$I->comment("Comment is kept to preserve the step key for backward compatibility");
		$I->comment("Comment is added to preserve the step key for backward compatibility");
		$I->comment("Entering Action Group [seeProductInCompareList] SeeProductInComparisonListActionGroup");
		$I->amOnPage("catalog/product_compare/index"); // stepKey: navigateToComparePageSeeProductInCompareList
		$I->waitForPageLoad(30); // stepKey: waitForStorefrontProductComparePageLoadSeeProductInCompareList
		$I->seeElement("//*[@id='product-comparison']//tr//strong[@class='product-item-name']/a[contains(text(), '" . $I->retrieveEntityField('product', 'name', 'test') . "')]"); // stepKey: seeProductInCompareListSeeProductInCompareList
		$I->comment("Exiting Action Group [seeProductInCompareList] SeeProductInComparisonListActionGroup");
		$I->comment("Comment is added to preserve the step key for backward compatibility");
		$I->comment("Comment is added to preserve the step key for backward compatibility");
		$I->comment("Entering Action Group [waitForPageLoad1] StorefrontGoToCategoryPageActionGroup");
		$I->amOnPage("/"); // stepKey: onFrontendWaitForPageLoad1
		$I->waitForPageLoad(30); // stepKey: waitForStorefrontPageLoadWaitForPageLoad1
		$I->click("//nav//a[span[contains(., '" . $I->retrieveEntityField('category', 'name', 'test') . "')]]"); // stepKey: toCategoryWaitForPageLoad1
		$I->waitForPageLoad(30); // stepKey: toCategoryWaitForPageLoad1WaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCategoryPageWaitForPageLoad1
		$I->comment("Exiting Action Group [waitForPageLoad1] StorefrontGoToCategoryPageActionGroup");
		$I->comment("Entering Action Group [clickClearAll] StorefrontRemoveFirstProductFromCompareActionGroup");
		$I->amOnPage("catalog/product_compare/index"); // stepKey: navigateToComparePageClickClearAll
		$I->waitForElementVisible("table.table-comparison a.delete", 30); // stepKey: waitForButtonClickClearAll
		$I->click("table.table-comparison a.delete"); // stepKey: clickOnButtonClickClearAll
		$I->waitForElementVisible("//footer[@class='modal-footer']/button[contains(@class, 'action-accept')]", 30); // stepKey: waitForModalClickClearAll
		$I->waitForPageLoad(30); // stepKey: waitForModalClickClearAllWaitForPageLoad
		$I->scrollTo("//footer[@class='modal-footer']/button[contains(@class, 'action-accept')]"); // stepKey: scrollToModalClickClearAll
		$I->waitForPageLoad(30); // stepKey: scrollToModalClickClearAllWaitForPageLoad
		$I->click("//footer[@class='modal-footer']/button[contains(@class, 'action-accept')]"); // stepKey: ClickOkButtonClickClearAll
		$I->waitForPageLoad(30); // stepKey: ClickOkButtonClickClearAllWaitForPageLoad
		$I->waitForElementVisible("div.message-success.success.message", 30); // stepKey: waitForSuccessMessageClickClearAll
		$I->comment("Exiting Action Group [clickClearAll] StorefrontRemoveFirstProductFromCompareActionGroup");
		$I->comment("Comment is added to preserve the step key for backward compatibility");
		$I->comment("Comment is added to preserve the step key for backward compatibility");
		$I->comment("Comment is added to preserve the step key for backward compatibility");
		$I->comment("Entering Action Group [addToCmpFromCategPage] StorefrontGoToCategoryPageActionGroup");
		$I->amOnPage("/"); // stepKey: onFrontendAddToCmpFromCategPage
		$I->waitForPageLoad(30); // stepKey: waitForStorefrontPageLoadAddToCmpFromCategPage
		$I->click("//nav//a[span[contains(., '" . $I->retrieveEntityField('category', 'name', 'test') . "')]]"); // stepKey: toCategoryAddToCmpFromCategPage
		$I->waitForPageLoad(30); // stepKey: toCategoryAddToCmpFromCategPageWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCategoryPageAddToCmpFromCategPage
		$I->comment("Exiting Action Group [addToCmpFromCategPage] StorefrontGoToCategoryPageActionGroup");
		$I->comment("Entering Action Group [hoverOverProduct] StorefrontHoverProductOnCategoryPageActionGroup");
		$I->moveMouseOver(".product-item-info"); // stepKey: hoverOverProductHoverOverProduct
		$I->comment("Exiting Action Group [hoverOverProduct] StorefrontHoverProductOnCategoryPageActionGroup");
		$I->comment("Entering Action Group [clickAddToCompare] StorefrontAddProductToCompareActionGroup");
		$I->click("a.action.tocompare"); // stepKey: clickAddToCompareClickAddToCompare
		$I->waitForElement("div.message-success.success.message", 30); // stepKey: waitForAddProductToCompareSuccessMessageClickAddToCompare
		$I->see("You added product " . $I->retrieveEntityField('product', 'name', 'test') . " to the comparison list.", "div.message-success.success.message"); // stepKey: assertAddProductToCompareSuccessMessageClickAddToCompare
		$I->comment("Exiting Action Group [clickAddToCompare] StorefrontAddProductToCompareActionGroup");
		$I->comment("Comment is added to preserve the step key for backward compatibility");
		$I->comment("Assert success message | Comment is kept to preserve the step key for backward compatibility");
		$I->comment("Comment is added to preserve the step key for backward compatibility");
		$I->comment("Comment is added to preserve the step key for backward compatibility");
		$I->comment("Comment is kept to preserve the step key for backward compatibility");
		$I->comment("Comment is kept to preserve the step key for backward compatibility");
		$I->comment("See product in the compare page");
		$I->comment("Comment is kept to preserve the step key for backward compatibility");
		$I->comment("Comment is added to preserve the step key for backward compatibility");
		$I->comment("Entering Action Group [seeProductInCompareList2] SeeProductInComparisonListActionGroup");
		$I->amOnPage("catalog/product_compare/index"); // stepKey: navigateToComparePageSeeProductInCompareList2
		$I->waitForPageLoad(30); // stepKey: waitForStorefrontProductComparePageLoadSeeProductInCompareList2
		$I->seeElement("//*[@id='product-comparison']//tr//strong[@class='product-item-name']/a[contains(text(), '" . $I->retrieveEntityField('product', 'name', 'test') . "')]"); // stepKey: seeProductInCompareListSeeProductInCompareList2
		$I->comment("Exiting Action Group [seeProductInCompareList2] SeeProductInComparisonListActionGroup");
	}
}
