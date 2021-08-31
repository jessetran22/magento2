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
 * @Title("MC-228: Customer should be able to sort bundle products by price when viewing products list")
 * @Description("Customer should be able to sort bundle products by price when viewing products list<h3>Test files</h3>app/code/Magento/Bundle/Test/Mftf/Test/StorefrontSortBundleProductsByPriceTest.xml<br>")
 * @TestCaseId("MC-228")
 * @group bundle
 */
class StorefrontSortBundleProductsByPriceTestCest
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
		$I->comment("Create category");
		$I->createEntity("createCategory", "hook", "SimpleSubCategory", [], []); // stepKey: createCategory
		$I->comment("Create simple products for first bundle product");
		$createFirstSimpleProductFields['price'] = "100.00";
		$I->createEntity("createFirstSimpleProduct", "hook", "SimpleProduct2", [], $createFirstSimpleProductFields); // stepKey: createFirstSimpleProduct
		$I->createEntity("createSecondSimpleProduct", "hook", "SimpleProduct2", [], []); // stepKey: createSecondSimpleProduct
		$I->comment("Create first bundle product");
		$I->createEntity("createFirstBundleProduct", "hook", "ApiBundleProductPriceViewRange", ["createCategory"], []); // stepKey: createFirstBundleProduct
		$I->createEntity("firstProductBundleOption", "hook", "DropDownBundleOption", ["createFirstBundleProduct"], []); // stepKey: firstProductBundleOption
		$I->createEntity("createFirstBundleLink", "hook", "ApiBundleLink", ["createFirstBundleProduct", "firstProductBundleOption", "createFirstSimpleProduct"], []); // stepKey: createFirstBundleLink
		$I->createEntity("createSecondBundleLink", "hook", "ApiBundleLink", ["createFirstBundleProduct", "firstProductBundleOption", "createSecondSimpleProduct"], []); // stepKey: createSecondBundleLink
		$I->comment("Create simple products for second bundle product");
		$createFirstProductFields['price'] = "10.00";
		$I->createEntity("createFirstProduct", "hook", "SimpleProduct2", [], $createFirstProductFields); // stepKey: createFirstProduct
		$I->createEntity("createSecondProduct", "hook", "SimpleProduct2", [], []); // stepKey: createSecondProduct
		$I->comment("Create second bundle product");
		$I->createEntity("createSecondBundleProduct", "hook", "ApiBundleProductPriceViewRange", ["createCategory"], []); // stepKey: createSecondBundleProduct
		$I->createEntity("secondProductBundleOption", "hook", "DropDownBundleOption", ["createSecondBundleProduct"], []); // stepKey: secondProductBundleOption
		$I->createEntity("createBundleLinkFirst", "hook", "ApiBundleLink", ["createSecondBundleProduct", "secondProductBundleOption", "createFirstProduct"], []); // stepKey: createBundleLinkFirst
		$I->createEntity("createBundleLinkSecond", "hook", "ApiBundleLink", ["createSecondBundleProduct", "secondProductBundleOption", "createSecondProduct"], []); // stepKey: createBundleLinkSecond
		$I->comment("Create simple products for third bundle product");
		$I->createEntity("createFirstProductForBundle", "hook", "SimpleProduct2", [], []); // stepKey: createFirstProductForBundle
		$createSecondProductForBundleFields['price'] = "500.00";
		$I->createEntity("createSecondProductForBundle", "hook", "SimpleProduct2", [], $createSecondProductForBundleFields); // stepKey: createSecondProductForBundle
		$I->comment("Create third bundle product");
		$I->createEntity("createThirdBundleProduct", "hook", "ApiBundleProductPriceViewRange", ["createCategory"], []); // stepKey: createThirdBundleProduct
		$I->createEntity("createThirdProductBundleOption", "hook", "DropDownBundleOption", ["createThirdBundleProduct"], []); // stepKey: createThirdProductBundleOption
		$I->createEntity("createBundleFirstLink", "hook", "ApiBundleLink", ["createThirdBundleProduct", "createThirdProductBundleOption", "createFirstProductForBundle"], []); // stepKey: createBundleFirstLink
		$I->createEntity("createBundleSecondLink", "hook", "ApiBundleLink", ["createThirdBundleProduct", "createThirdProductBundleOption", "createSecondProductForBundle"], []); // stepKey: createBundleSecondLink
		$I->comment("Perform CLI reindex");
		$I->comment("Entering Action Group [reindex] CliIndexerReindexActionGroup");
		$reindexSpecifiedIndexersReindex = $I->magentoCLI("indexer:reindex", 60, "cataloginventory_stock catalog_product_price"); // stepKey: reindexSpecifiedIndexersReindex
		$I->comment($reindexSpecifiedIndexersReindex);
		$I->comment("Exiting Action Group [reindex] CliIndexerReindexActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Delete all created data");
		$I->deleteEntity("createCategory", "hook"); // stepKey: deleteCategory
		$I->deleteEntity("createFirstSimpleProduct", "hook"); // stepKey: deleteFirstSimpleProduct
		$I->deleteEntity("createSecondSimpleProduct", "hook"); // stepKey: deleteSecondSimpleProduct
		$I->deleteEntity("createFirstBundleProduct", "hook"); // stepKey: deleteFirstBundleProduct
		$I->deleteEntity("createFirstProduct", "hook"); // stepKey: deleteFirstProduct
		$I->deleteEntity("createSecondProduct", "hook"); // stepKey: deleteSecondProduct
		$I->deleteEntity("createSecondBundleProduct", "hook"); // stepKey: deleteSecondBundleProduct
		$I->deleteEntity("createFirstProductForBundle", "hook"); // stepKey: deleteFirstProductForBundle
		$I->deleteEntity("createSecondProductForBundle", "hook"); // stepKey: deleteSecondProductForBundle
		$I->deleteEntity("createThirdBundleProduct", "hook"); // stepKey: deleteThirdBundleProduct
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
	 * @Features({"Bundle"})
	 * @Stories({"Bundle products list on Storefront"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StorefrontSortBundleProductsByPriceTest(AcceptanceTester $I)
	{
		$I->comment("Open created category on Storefront");
		$I->comment("Entering Action Group [openCategoryPage] StorefrontGoToCategoryPageActionGroup");
		$I->amOnPage("/"); // stepKey: onFrontendOpenCategoryPage
		$I->waitForPageLoad(30); // stepKey: waitForStorefrontPageLoadOpenCategoryPage
		$I->click("//nav//a[span[contains(., '" . $I->retrieveEntityField('createCategory', 'name', 'test') . "')]]"); // stepKey: toCategoryOpenCategoryPage
		$I->waitForPageLoad(30); // stepKey: toCategoryOpenCategoryPageWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCategoryPageOpenCategoryPage
		$I->comment("Exiting Action Group [openCategoryPage] StorefrontGoToCategoryPageActionGroup");
		$I->comment("Assert first bundle products in category product grid");
		$I->comment("Entering Action Group [assertFirstBundleProduct] AssertStorefrontProductIsPresentOnCategoryPageActionGroup");
		$I->waitForElementVisible("//main//li//a[contains(text(), '" . $I->retrieveEntityField('createFirstBundleProduct', 'name', 'test') . "')]", 30); // stepKey: assertProductNameAssertFirstBundleProduct
		$I->comment("Exiting Action Group [assertFirstBundleProduct] AssertStorefrontProductIsPresentOnCategoryPageActionGroup");
		$I->comment("Entering Action Group [seePriceRangeFromForFirstBundleProduct] AssertStorefrontElementVisibleActionGroup");
		$I->waitForElementVisible("div[data-product-id='" . $I->retrieveEntityField('createFirstBundleProduct', 'id', 'test') . "'] .price-from", 60); // stepKey: waitForElementVisibleSeePriceRangeFromForFirstBundleProduct
		$I->see("From $100.00", "div[data-product-id='" . $I->retrieveEntityField('createFirstBundleProduct', 'id', 'test') . "'] .price-from"); // stepKey: assertElementSeePriceRangeFromForFirstBundleProduct
		$I->comment("Exiting Action Group [seePriceRangeFromForFirstBundleProduct] AssertStorefrontElementVisibleActionGroup");
		$I->comment("Entering Action Group [seePriceRangeToForFirstBundleProduct] AssertStorefrontElementVisibleActionGroup");
		$I->waitForElementVisible("div[data-product-id='" . $I->retrieveEntityField('createFirstBundleProduct', 'id', 'test') . "'] .price-to", 60); // stepKey: waitForElementVisibleSeePriceRangeToForFirstBundleProduct
		$I->see("To $123.00", "div[data-product-id='" . $I->retrieveEntityField('createFirstBundleProduct', 'id', 'test') . "'] .price-to"); // stepKey: assertElementSeePriceRangeToForFirstBundleProduct
		$I->comment("Exiting Action Group [seePriceRangeToForFirstBundleProduct] AssertStorefrontElementVisibleActionGroup");
		$I->comment("Assert second bundle products in category product grid");
		$I->comment("Entering Action Group [assertSecondBundleProduct] AssertStorefrontProductIsPresentOnCategoryPageActionGroup");
		$I->waitForElementVisible("//main//li//a[contains(text(), '" . $I->retrieveEntityField('createSecondBundleProduct', 'name', 'test') . "')]", 30); // stepKey: assertProductNameAssertSecondBundleProduct
		$I->comment("Exiting Action Group [assertSecondBundleProduct] AssertStorefrontProductIsPresentOnCategoryPageActionGroup");
		$I->comment("Entering Action Group [seePriceRangeFromForSecondBundleProduct] AssertStorefrontElementVisibleActionGroup");
		$I->waitForElementVisible("div[data-product-id='" . $I->retrieveEntityField('createSecondBundleProduct', 'id', 'test') . "'] .price-from", 60); // stepKey: waitForElementVisibleSeePriceRangeFromForSecondBundleProduct
		$I->see("From $10.00", "div[data-product-id='" . $I->retrieveEntityField('createSecondBundleProduct', 'id', 'test') . "'] .price-from"); // stepKey: assertElementSeePriceRangeFromForSecondBundleProduct
		$I->comment("Exiting Action Group [seePriceRangeFromForSecondBundleProduct] AssertStorefrontElementVisibleActionGroup");
		$I->comment("Entering Action Group [seePriceRangeToForSecondBundleProduct] AssertStorefrontElementVisibleActionGroup");
		$I->waitForElementVisible("div[data-product-id='" . $I->retrieveEntityField('createSecondBundleProduct', 'id', 'test') . "'] .price-to", 60); // stepKey: waitForElementVisibleSeePriceRangeToForSecondBundleProduct
		$I->see("To $123.00", "div[data-product-id='" . $I->retrieveEntityField('createSecondBundleProduct', 'id', 'test') . "'] .price-to"); // stepKey: assertElementSeePriceRangeToForSecondBundleProduct
		$I->comment("Exiting Action Group [seePriceRangeToForSecondBundleProduct] AssertStorefrontElementVisibleActionGroup");
		$I->comment("Assert third bundle products in category product grid");
		$I->comment("Entering Action Group [assertThirdBundleProduct] AssertStorefrontProductIsPresentOnCategoryPageActionGroup");
		$I->waitForElementVisible("//main//li//a[contains(text(), '" . $I->retrieveEntityField('createThirdBundleProduct', 'name', 'test') . "')]", 30); // stepKey: assertProductNameAssertThirdBundleProduct
		$I->comment("Exiting Action Group [assertThirdBundleProduct] AssertStorefrontProductIsPresentOnCategoryPageActionGroup");
		$I->comment("Entering Action Group [seePriceRangeFromForThirdBundleProduct] AssertStorefrontElementVisibleActionGroup");
		$I->waitForElementVisible("div[data-product-id='" . $I->retrieveEntityField('createThirdBundleProduct', 'id', 'test') . "'] .price-from", 60); // stepKey: waitForElementVisibleSeePriceRangeFromForThirdBundleProduct
		$I->see("From $123.00", "div[data-product-id='" . $I->retrieveEntityField('createThirdBundleProduct', 'id', 'test') . "'] .price-from"); // stepKey: assertElementSeePriceRangeFromForThirdBundleProduct
		$I->comment("Exiting Action Group [seePriceRangeFromForThirdBundleProduct] AssertStorefrontElementVisibleActionGroup");
		$I->comment("Entering Action Group [seePriceRangeToForThirdBundleProduct] AssertStorefrontElementVisibleActionGroup");
		$I->waitForElementVisible("div[data-product-id='" . $I->retrieveEntityField('createThirdBundleProduct', 'id', 'test') . "'] .price-to", 60); // stepKey: waitForElementVisibleSeePriceRangeToForThirdBundleProduct
		$I->see("To $500.00", "div[data-product-id='" . $I->retrieveEntityField('createThirdBundleProduct', 'id', 'test') . "'] .price-to"); // stepKey: assertElementSeePriceRangeToForThirdBundleProduct
		$I->comment("Exiting Action Group [seePriceRangeToForThirdBundleProduct] AssertStorefrontElementVisibleActionGroup");
		$I->comment("Switch category view to List mode");
		$I->comment("Entering Action Group [switchCategoryViewToListMode] StorefrontSwitchCategoryViewToListModeActionGroup");
		$I->click("#mode-list"); // stepKey: switchCategoryViewToListModeSwitchCategoryViewToListMode
		$I->waitForElement("#page-title-heading span", 30); // stepKey: waitForCategoryReloadSwitchCategoryViewToListMode
		$I->comment("Exiting Action Group [switchCategoryViewToListMode] StorefrontSwitchCategoryViewToListModeActionGroup");
		$I->comment("Sort products By Price");
		$I->comment("Entering Action Group [sortProductByPrice] StorefrontCategoryPageSortProductActionGroup");
		$I->selectOption(".//*[@class='toolbar toolbar-products'][1]//*[@id='sorter']", "Price"); // stepKey: selectSortByParameterSortProductByPrice
		$I->waitForPageLoad(30); // stepKey: selectSortByParameterSortProductByPriceWaitForPageLoad
		$I->comment("Exiting Action Group [sortProductByPrice] StorefrontCategoryPageSortProductActionGroup");
		$I->comment("Set Ascending Direction");
		$I->comment("Entering Action Group [setAscendingDirection] StorefrontCategoryPageSortAscendingActionGroup");
		$I->click(".//*[@class='toolbar toolbar-products'][1]//a[contains(@class, 'sort-asc')]"); // stepKey: setAscendingDirectionSetAscendingDirection
		$I->waitForPageLoad(30); // stepKey: setAscendingDirectionSetAscendingDirectionWaitForPageLoad
		$I->comment("Exiting Action Group [setAscendingDirection] StorefrontCategoryPageSortAscendingActionGroup");
		$I->comment("Assert new products positions");
		$I->comment("Entering Action Group [seeProductFirstPosition] AssertStorefrontElementVisibleActionGroup");
		$I->waitForElementVisible(".products.list.items.product-items li:nth-of-type(1) .product-item-link", 60); // stepKey: waitForElementVisibleSeeProductFirstPosition
		$I->waitForPageLoad(30); // stepKey: waitForElementVisibleSeeProductFirstPositionWaitForPageLoad
		$I->see($I->retrieveEntityField('createThirdBundleProduct', 'name', 'test'), ".products.list.items.product-items li:nth-of-type(1) .product-item-link"); // stepKey: assertElementSeeProductFirstPosition
		$I->waitForPageLoad(30); // stepKey: assertElementSeeProductFirstPositionWaitForPageLoad
		$I->comment("Exiting Action Group [seeProductFirstPosition] AssertStorefrontElementVisibleActionGroup");
		$I->comment("Entering Action Group [seeProductSecondPosition] AssertStorefrontElementVisibleActionGroup");
		$I->waitForElementVisible(".products.list.items.product-items li:nth-of-type(2) .product-item-link", 60); // stepKey: waitForElementVisibleSeeProductSecondPosition
		$I->waitForPageLoad(30); // stepKey: waitForElementVisibleSeeProductSecondPositionWaitForPageLoad
		$I->see($I->retrieveEntityField('createFirstBundleProduct', 'name', 'test'), ".products.list.items.product-items li:nth-of-type(2) .product-item-link"); // stepKey: assertElementSeeProductSecondPosition
		$I->waitForPageLoad(30); // stepKey: assertElementSeeProductSecondPositionWaitForPageLoad
		$I->comment("Exiting Action Group [seeProductSecondPosition] AssertStorefrontElementVisibleActionGroup");
		$I->comment("Entering Action Group [seeProductThirdPosition] AssertStorefrontElementVisibleActionGroup");
		$I->waitForElementVisible(".products.list.items.product-items li:nth-of-type(3) .product-item-link", 60); // stepKey: waitForElementVisibleSeeProductThirdPosition
		$I->waitForPageLoad(30); // stepKey: waitForElementVisibleSeeProductThirdPositionWaitForPageLoad
		$I->see($I->retrieveEntityField('createSecondBundleProduct', 'name', 'test'), ".products.list.items.product-items li:nth-of-type(3) .product-item-link"); // stepKey: assertElementSeeProductThirdPosition
		$I->waitForPageLoad(30); // stepKey: assertElementSeeProductThirdPositionWaitForPageLoad
		$I->comment("Exiting Action Group [seeProductThirdPosition] AssertStorefrontElementVisibleActionGroup");
		$I->comment("Set Descending Direction");
		$I->comment("Entering Action Group [setDescendingDirection] StorefrontCategoryPageSortDescendingActionGroup");
		$I->click(".//*[@class='toolbar toolbar-products'][1]//a[contains(@class, 'sort-desc')]"); // stepKey: setDescendingDirectionSetDescendingDirection
		$I->waitForPageLoad(30); // stepKey: setDescendingDirectionSetDescendingDirectionWaitForPageLoad
		$I->comment("Exiting Action Group [setDescendingDirection] StorefrontCategoryPageSortDescendingActionGroup");
		$I->comment("Assert new products positions");
		$I->comment("Entering Action Group [seeProductNewFirstPosition] AssertStorefrontElementVisibleActionGroup");
		$I->waitForElementVisible(".products.list.items.product-items li:nth-of-type(1) .product-item-link", 60); // stepKey: waitForElementVisibleSeeProductNewFirstPosition
		$I->waitForPageLoad(30); // stepKey: waitForElementVisibleSeeProductNewFirstPositionWaitForPageLoad
		$I->see($I->retrieveEntityField('createSecondBundleProduct', 'name', 'test'), ".products.list.items.product-items li:nth-of-type(1) .product-item-link"); // stepKey: assertElementSeeProductNewFirstPosition
		$I->waitForPageLoad(30); // stepKey: assertElementSeeProductNewFirstPositionWaitForPageLoad
		$I->comment("Exiting Action Group [seeProductNewFirstPosition] AssertStorefrontElementVisibleActionGroup");
		$I->comment("Entering Action Group [seeProductNewSecondPosition] AssertStorefrontElementVisibleActionGroup");
		$I->waitForElementVisible(".products.list.items.product-items li:nth-of-type(2) .product-item-link", 60); // stepKey: waitForElementVisibleSeeProductNewSecondPosition
		$I->waitForPageLoad(30); // stepKey: waitForElementVisibleSeeProductNewSecondPositionWaitForPageLoad
		$I->see($I->retrieveEntityField('createFirstBundleProduct', 'name', 'test'), ".products.list.items.product-items li:nth-of-type(2) .product-item-link"); // stepKey: assertElementSeeProductNewSecondPosition
		$I->waitForPageLoad(30); // stepKey: assertElementSeeProductNewSecondPositionWaitForPageLoad
		$I->comment("Exiting Action Group [seeProductNewSecondPosition] AssertStorefrontElementVisibleActionGroup");
		$I->comment("Entering Action Group [seeProductNewThirdPosition] AssertStorefrontElementVisibleActionGroup");
		$I->waitForElementVisible(".products.list.items.product-items li:nth-of-type(3) .product-item-link", 60); // stepKey: waitForElementVisibleSeeProductNewThirdPosition
		$I->waitForPageLoad(30); // stepKey: waitForElementVisibleSeeProductNewThirdPositionWaitForPageLoad
		$I->see($I->retrieveEntityField('createThirdBundleProduct', 'name', 'test'), ".products.list.items.product-items li:nth-of-type(3) .product-item-link"); // stepKey: assertElementSeeProductNewThirdPosition
		$I->waitForPageLoad(30); // stepKey: assertElementSeeProductNewThirdPositionWaitForPageLoad
		$I->comment("Exiting Action Group [seeProductNewThirdPosition] AssertStorefrontElementVisibleActionGroup");
	}
}
