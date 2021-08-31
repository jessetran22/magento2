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
 * @Title("MC-30209: Display All Products on a Page")
 * @Description("Set Up Elastic Search and Display all Products on Page<h3>Test files</h3>app/code/Magento/Catalog/Test/Mftf/Test/StoreFrontProductsDisplayUsingElasticSearchTest.xml<br>")
 * @TestCaseId("MC-30209")
 * @group Catalog
 * @group SearchEngineElasticsearch
 */
class StoreFrontProductsDisplayUsingElasticSearchTestCest
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
		$I->comment("Create Category and Simple Products");
		$I->createEntity("createCategory1", "hook", "SimpleSubCategory", [], []); // stepKey: createCategory1
		$I->createEntity("createSimpleProduct", "hook", "SimpleProduct", ["createCategory1"], []); // stepKey: createSimpleProduct
		$I->createEntity("createSimpleProduct2", "hook", "SimpleProduct", ["createCategory1"], []); // stepKey: createSimpleProduct2
		$I->createEntity("createSimpleProduct3", "hook", "SimpleProduct", ["createCategory1"], []); // stepKey: createSimpleProduct3
		$I->createEntity("createSimpleProduct4", "hook", "SimpleProduct", ["createCategory1"], []); // stepKey: createSimpleProduct4
		$I->createEntity("createSimpleProduct5", "hook", "SimpleProduct", ["createCategory1"], []); // stepKey: createSimpleProduct5
		$I->createEntity("createSimpleProduct6", "hook", "SimpleProduct", ["createCategory1"], []); // stepKey: createSimpleProduct6
		$I->createEntity("createSimpleProduct7", "hook", "SimpleProduct", ["createCategory1"], []); // stepKey: createSimpleProduct7
		$I->createEntity("createSimpleProduct8", "hook", "SimpleProduct", ["createCategory1"], []); // stepKey: createSimpleProduct8
		$I->createEntity("createSimpleProduct9", "hook", "SimpleProduct", ["createCategory1"], []); // stepKey: createSimpleProduct9
		$I->createEntity("createSimpleProduct10", "hook", "SimpleProduct", ["createCategory1"], []); // stepKey: createSimpleProduct10
		$I->createEntity("createSimpleProduct11", "hook", "SimpleProduct", ["createCategory1"], []); // stepKey: createSimpleProduct11
		$I->createEntity("createSimpleProduct12", "hook", "SimpleProduct", ["createCategory1"], []); // stepKey: createSimpleProduct12
		$I->createEntity("createSimpleProduct13", "hook", "SimpleProduct", ["createCategory1"], []); // stepKey: createSimpleProduct13
		$I->createEntity("createSimpleProduct14", "hook", "SimpleProduct", ["createCategory1"], []); // stepKey: createSimpleProduct14
		$I->createEntity("createSimpleProduct15", "hook", "SimpleProduct", ["createCategory1"], []); // stepKey: createSimpleProduct15
		$I->createEntity("createSimpleProduct16", "hook", "SimpleProduct", ["createCategory1"], []); // stepKey: createSimpleProduct16
		$I->createEntity("createSimpleProduct17", "hook", "SimpleProduct", ["createCategory1"], []); // stepKey: createSimpleProduct17
		$I->createEntity("createSimpleProduct18", "hook", "SimpleProduct", ["createCategory1"], []); // stepKey: createSimpleProduct18
		$I->createEntity("createSimpleProduct19", "hook", "SimpleProduct", ["createCategory1"], []); // stepKey: createSimpleProduct19
		$I->createEntity("createSimpleProduct20", "hook", "SimpleProduct", ["createCategory1"], []); // stepKey: createSimpleProduct20
		$I->createEntity("createSimpleProduct21", "hook", "SimpleProduct", ["createCategory1"], []); // stepKey: createSimpleProduct21
		$I->createEntity("createSimpleProduct22", "hook", "SimpleProduct", ["createCategory1"], []); // stepKey: createSimpleProduct22
		$I->createEntity("createSimpleProduct23", "hook", "SimpleProduct", ["createCategory1"], []); // stepKey: createSimpleProduct23
		$I->createEntity("createSimpleProduct24", "hook", "SimpleProduct", ["createCategory1"], []); // stepKey: createSimpleProduct24
		$I->createEntity("createSimpleProduct25", "hook", "SimpleProduct", ["createCategory1"], []); // stepKey: createSimpleProduct25
		$I->createEntity("createSimpleProduct26", "hook", "SimpleProduct", ["createCategory1"], []); // stepKey: createSimpleProduct26
		$I->createEntity("createSimpleProduct27", "hook", "SimpleProduct", ["createCategory1"], []); // stepKey: createSimpleProduct27
		$I->createEntity("createSimpleProduct28", "hook", "SimpleProduct", ["createCategory1"], []); // stepKey: createSimpleProduct28
		$I->createEntity("createSimpleProduct29", "hook", "SimpleProduct", ["createCategory1"], []); // stepKey: createSimpleProduct29
		$I->createEntity("createSimpleProduct30", "hook", "SimpleProduct", ["createCategory1"], []); // stepKey: createSimpleProduct30
		$reindexInvalidatedIndices = $I->magentoCron("index", 90); // stepKey: reindexInvalidatedIndices
		$I->comment($reindexInvalidatedIndices);
		$I->comment("Adding the comment to replace CliIndexerReindexActionGroup action group ('indexer:reindex' commands) for preserving Backward Compatibility");
		$I->comment("Entering Action Group [cleanFullPageCache] CliCacheCleanActionGroup");
		$cleanSpecifiedCacheCleanFullPageCache = $I->magentoCLI("cache:clean", 60, "full_page"); // stepKey: cleanSpecifiedCacheCleanFullPageCache
		$I->comment($cleanSpecifiedCacheCleanFullPageCache);
		$I->comment("Exiting Action Group [cleanFullPageCache] CliCacheCleanActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Delete created products, category");
		$I->deleteEntity("createCategory1", "hook"); // stepKey: deleteCategory
		$I->deleteEntity("createSimpleProduct", "hook"); // stepKey: deleteSimpleProduct1
		$I->deleteEntity("createSimpleProduct2", "hook"); // stepKey: deleteSimpleProduct2
		$I->deleteEntity("createSimpleProduct3", "hook"); // stepKey: deleteSimpleProduct3
		$I->deleteEntity("createSimpleProduct4", "hook"); // stepKey: deleteSimpleProduct4
		$I->deleteEntity("createSimpleProduct5", "hook"); // stepKey: deleteSimpleProduct5
		$I->deleteEntity("createSimpleProduct6", "hook"); // stepKey: deleteSimpleProduct6
		$I->deleteEntity("createSimpleProduct7", "hook"); // stepKey: deleteSimpleProduct7
		$I->deleteEntity("createSimpleProduct8", "hook"); // stepKey: deleteSimpleProduct8
		$I->deleteEntity("createSimpleProduct9", "hook"); // stepKey: deleteSimpleProduct9
		$I->deleteEntity("createSimpleProduct10", "hook"); // stepKey: deleteSimpleProduct10
		$I->deleteEntity("createSimpleProduct11", "hook"); // stepKey: deleteSimpleProduct11
		$I->deleteEntity("createSimpleProduct12", "hook"); // stepKey: deleteSimpleProduct12
		$I->deleteEntity("createSimpleProduct13", "hook"); // stepKey: deleteSimpleProduct13
		$I->deleteEntity("createSimpleProduct14", "hook"); // stepKey: deleteSimpleProduct14
		$I->deleteEntity("createSimpleProduct15", "hook"); // stepKey: deleteSimpleProduct15
		$I->deleteEntity("createSimpleProduct16", "hook"); // stepKey: deleteSimpleProduct16
		$I->deleteEntity("createSimpleProduct17", "hook"); // stepKey: deleteSimpleProduct17
		$I->deleteEntity("createSimpleProduct18", "hook"); // stepKey: deleteSimpleProduct18
		$I->deleteEntity("createSimpleProduct19", "hook"); // stepKey: deleteSimpleProduct19
		$I->deleteEntity("createSimpleProduct20", "hook"); // stepKey: deleteSimpleProduct20
		$I->deleteEntity("createSimpleProduct21", "hook"); // stepKey: deleteSimpleProduct21
		$I->deleteEntity("createSimpleProduct22", "hook"); // stepKey: deleteSimpleProduct22
		$I->deleteEntity("createSimpleProduct23", "hook"); // stepKey: deleteSimpleProduct23
		$I->deleteEntity("createSimpleProduct24", "hook"); // stepKey: deleteSimpleProduct24
		$I->deleteEntity("createSimpleProduct25", "hook"); // stepKey: deleteSimpleProduct25
		$I->deleteEntity("createSimpleProduct26", "hook"); // stepKey: deleteSimpleProduct26
		$I->deleteEntity("createSimpleProduct27", "hook"); // stepKey: deleteSimpleProduct27
		$I->deleteEntity("createSimpleProduct28", "hook"); // stepKey: deleteSimpleProduct28
		$I->deleteEntity("createSimpleProduct29", "hook"); // stepKey: deleteSimpleProduct29
		$I->deleteEntity("createSimpleProduct30", "hook"); // stepKey: deleteSimpleProduct30
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
	 * @Stories({"Display All Products"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Features({"Catalog"})
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StoreFrontProductsDisplayUsingElasticSearchTest(AcceptanceTester $I)
	{
		$I->comment("Open Storefront on the myCategory page");
		$I->comment("Entering Action Group [goToStorefrontCategory] StorefrontNavigateCategoryPageActionGroup");
		$I->comment("Open category page on storefront");
		$I->amOnPage("/" . $I->retrieveEntityField('createCategory1', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: navigateStorefrontCategoryPageGoToStorefrontCategory
		$I->waitForPageLoad(30); // stepKey: waitForCategoryPageLoadGoToStorefrontCategory
		$I->comment("Exiting Action Group [goToStorefrontCategory] StorefrontNavigateCategoryPageActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForStorefrontCategoryPageLoad
		$I->comment("Select 12 items per page and verify number of products displayed in each page");
		$I->conditionalClick(".//*[@class='toolbar toolbar-products'][1]//*[@id='mode-grid']", ".//*[@class='toolbar toolbar-products'][1]//*[@id='mode-grid']", true); // stepKey: seeProductGridIsActive
		$I->waitForPageLoad(30); // stepKey: seeProductGridIsActiveWaitForPageLoad
		$I->scrollTo("//*[@class='toolbar toolbar-products'][2]//select[@id='limiter']"); // stepKey: scrollToBottomToolbarSection
		$I->selectOption("//*[@class='toolbar toolbar-products'][2]//select[@id='limiter']", "12"); // stepKey: selectPerPageOption
		$I->comment("Verify number of products displayed in First Page");
		$I->seeNumberOfElements("a.product-item-link", "12"); // stepKey: seeNumberOfProductsInFirstPage
		$I->waitForPageLoad(30); // stepKey: seeNumberOfProductsInFirstPageWaitForPageLoad
		$I->comment("Verify number of products displayed in Second Page");
		$I->scrollTo(".//*[@class='toolbar toolbar-products'][2]//a[contains(@class, 'next')]"); // stepKey: scrollToNextButton
		$I->waitForPageLoad(30); // stepKey: scrollToNextButtonWaitForPageLoad
		$I->click(".//*[@class='toolbar toolbar-products'][2]//a[contains(@class, 'next')]"); // stepKey: clickOnNextPage
		$I->waitForPageLoad(30); // stepKey: clickOnNextPageWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoad4
		$I->seeNumberOfElements("a.product-item-link", "12"); // stepKey: seeNumberOfProductsInSecondPage
		$I->waitForPageLoad(30); // stepKey: seeNumberOfProductsInSecondPageWaitForPageLoad
		$I->comment("Verify number of products displayed in third  Page");
		$I->scrollTo(".//*[@class='toolbar toolbar-products'][2]//a[contains(@class, 'next')]"); // stepKey: scrollToNextButton1
		$I->waitForPageLoad(30); // stepKey: scrollToNextButton1WaitForPageLoad
		$I->click(".//*[@class='toolbar toolbar-products'][2]//a[contains(@class, 'next')]"); // stepKey: clickOnNextPage1
		$I->waitForPageLoad(30); // stepKey: clickOnNextPage1WaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoad2
		$I->seeNumberOfElements("a.product-item-link", "6"); // stepKey: seeNumberOfProductsInThirdPage
		$I->waitForPageLoad(30); // stepKey: seeNumberOfProductsInThirdPageWaitForPageLoad
		$I->comment("Select First Page using page number");
		$I->scrollTo(".//*[@class='toolbar toolbar-products'][2]//a[contains(@class, 'previous')]"); // stepKey: scrollToPreviousPage4
		$I->waitForPageLoad(30); // stepKey: scrollToPreviousPage4WaitForPageLoad
		$I->click("//*[@class='toolbar toolbar-products'][2]//a[contains(@class, 'page')]//span[2][contains(text() ,'1')]"); // stepKey: clickOnFirstPage
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoad9
		$I->seeNumberOfElements("a.product-item-link", "12"); // stepKey: seeNumberOfProductsFirstPage2
		$I->waitForPageLoad(30); // stepKey: seeNumberOfProductsFirstPage2WaitForPageLoad
		$I->comment("Select 24 items per page and verify number of products displayed in each page");
		$I->scrollTo("//*[@class='toolbar toolbar-products'][2]//select[@id='limiter']"); // stepKey: scrollToPerPage
		$I->selectOption("//*[@class='toolbar toolbar-products'][2]//select[@id='limiter']", "24"); // stepKey: selectPerPageOption1
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoad10
		$I->seeNumberOfElements("a.product-item-link", "24"); // stepKey: seeNumberOfProductsInFirstPage3
		$I->waitForPageLoad(30); // stepKey: seeNumberOfProductsInFirstPage3WaitForPageLoad
		$I->scrollTo(".//*[@class='toolbar toolbar-products'][2]//a[contains(@class, 'next')]"); // stepKey: scrollToNextButton2
		$I->waitForPageLoad(30); // stepKey: scrollToNextButton2WaitForPageLoad
		$I->click(".//*[@class='toolbar toolbar-products'][2]//a[contains(@class, 'next')]"); // stepKey: clickOnNextPage2
		$I->waitForPageLoad(30); // stepKey: clickOnNextPage2WaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoad11
		$I->seeNumberOfElements("a.product-item-link", "6"); // stepKey: seeNumberOfProductsInSecondPage3
		$I->waitForPageLoad(30); // stepKey: seeNumberOfProductsInSecondPage3WaitForPageLoad
		$I->comment("Select First Page using page number");
		$I->scrollTo("//*[@class='toolbar toolbar-products'][2]//a[contains(@class, 'page')]//span[2][contains(text() ,'1')]"); // stepKey: scrollToPreviousPage5
		$I->click("//*[@class='toolbar toolbar-products'][2]//a[contains(@class, 'page')]//span[2][contains(text() ,'1')]"); // stepKey: clickOnFirstPage2
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoad13
		$I->comment("Select 36 items per page  and verify number of products displayed in each page");
		$I->scrollTo("//*[@class='toolbar toolbar-products'][2]//select[@id='limiter']"); // stepKey: scrollToPerPage4
		$I->selectOption("//*[@class='toolbar toolbar-products'][2]//select[@id='limiter']", "36"); // stepKey: selectPerPageOption2
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoad12
		$I->seeNumberOfElements("a.product-item-link", "30"); // stepKey: seeNumberOfProductsInFirstPage4
		$I->waitForPageLoad(30); // stepKey: seeNumberOfProductsInFirstPage4WaitForPageLoad
	}
}
