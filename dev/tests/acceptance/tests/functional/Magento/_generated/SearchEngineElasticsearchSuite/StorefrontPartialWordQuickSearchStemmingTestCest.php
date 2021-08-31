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
 * @Title("MC-41570: Partial word search should match only the documents that contain the words of a provided text, in the same order as provided")
 * @Description("Partial word search should match only the documents that contain the words of a provided text, in the same order as provided<h3>Test files</h3>app/code/Magento/CatalogSearch/Test/Mftf/Test/StorefrontPartialWordQuickSearchStemmingTest.xml<br>")
 * @TestCaseId("MC-41570")
 * @group SearchEngineElasticsearch
 */
class StorefrontPartialWordQuickSearchStemmingTestCest
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
		$I->comment("Create category");
		$I->createEntity("category1", "hook", "SimpleSubCategory", [], []); // stepKey: category1
		$I->comment("Create product1");
		$product1Fields['name'] = "5127SS YALE JUNIOR KNOB ENTRANCE SET 5 PINS SATIN STAI";
		$I->createEntity("product1", "hook", "SimpleProduct", ["category1"], $product1Fields); // stepKey: product1
		$I->comment("Create product2");
		$product2Fields['name'] = "5127AC YALE JUNIOR KNOB ENTRANCE SET 5 PINS ANTIQUE CO";
		$I->createEntity("product2", "hook", "SimpleProduct", ["category1"], $product2Fields); // stepKey: product2
		$I->comment("Create product3");
		$product3Fields['name'] = "5127AB YALE JUNIOR KNOB ENTRANCE SET 5 PINS ANTIQUE BRASS";
		$I->createEntity("product3", "hook", "SimpleProduct", ["category1"], $product3Fields); // stepKey: product3
		$I->comment("Create product4");
		$product4Fields['sku'] = "5127SS-YALE";
		$I->createEntity("product4", "hook", "SimpleProduct", ["category1"], $product4Fields); // stepKey: product4
		$I->comment("Create product5");
		$product5Fields['sku'] = "5127AC-CO";
		$I->createEntity("product5", "hook", "SimpleProduct", ["category1"], $product5Fields); // stepKey: product5
		$I->comment("Create product6");
		$product6Fields['sku'] = "5127AB-BRASS";
		$I->createEntity("product6", "hook", "SimpleProduct", ["category1"], $product6Fields); // stepKey: product6
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Delete category");
		$I->deleteEntity("category1", "hook"); // stepKey: deleteCategory
		$I->comment("Delete product1");
		$I->deleteEntity("product1", "hook"); // stepKey: deleteProduct1
		$I->comment("Delete product2");
		$I->deleteEntity("product2", "hook"); // stepKey: deleteProduct2
		$I->comment("Delete product3");
		$I->deleteEntity("product3", "hook"); // stepKey: deleteProduct3
		$I->comment("Delete product4");
		$I->deleteEntity("product4", "hook"); // stepKey: deleteProduct4
		$I->comment("Delete product5");
		$I->deleteEntity("product5", "hook"); // stepKey: deleteProduct5
		$I->comment("Delete product6");
		$I->deleteEntity("product6", "hook"); // stepKey: deleteProduct6
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
	 * @Features({"CatalogSearch"})
	 * @Stories({"Partial Word search using Elasticsearch"})
	 * @Severity(level = SeverityLevel::MINOR)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StorefrontPartialWordQuickSearchStemmingTest(AcceptanceTester $I)
	{
		$I->comment("Navigate to home page");
		$I->comment("Entering Action Group [goToHomePage] StorefrontOpenHomePageActionGroup");
		$I->amOnPage("/"); // stepKey: goToStorefrontPageGoToHomePage
		$I->waitForPageLoad(30); // stepKey: waitForStorefrontPageLoadGoToHomePage
		$I->comment("Exiting Action Group [goToHomePage] StorefrontOpenHomePageActionGroup");
		$I->comment("Search for word \"5127S\"");
		$I->comment("Entering Action Group [search1] StorefrontCheckQuickSearchStringActionGroup");
		$I->fillField("#search", "5127S"); // stepKey: fillInputSearch1
		$I->submitForm("#search", []); // stepKey: submitQuickSearchSearch1
		$I->seeInCurrentUrl("/catalogsearch/result/"); // stepKey: checkUrlSearch1
		$I->dontSeeInCurrentUrl("form_key="); // stepKey: checkUrlFormKeySearch1
		$I->seeInTitle("Search results for: '5127S'"); // stepKey: assertQuickSearchTitleSearch1
		$I->see("Search results for: '5127S'", ".page-title span"); // stepKey: assertQuickSearchNameSearch1
		$I->comment("Exiting Action Group [search1] StorefrontCheckQuickSearchStringActionGroup");
		$I->comment("Assert that product1 is present in the search result");
		$I->comment("Entering Action Group [seeProduct1] StorefrontAssertProductNameOnProductMainPageActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForTheProductPageToLoadSeeProduct1
		$I->see($I->retrieveEntityField('product1', 'name', 'test'), ".product-item-name"); // stepKey: seeProductNameSeeProduct1
		$I->comment("Exiting Action Group [seeProduct1] StorefrontAssertProductNameOnProductMainPageActionGroup");
		$I->comment("Assert that product2 is not present in the search result");
		$I->comment("Entering Action Group [dontSeeProduct2] AssertStorefrontProductNameIsNotOnProductMainPageActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForTheProductPageToLoadDontSeeProduct2
		$I->dontSee($I->retrieveEntityField('product2', 'name', 'test'), ".product-item-name"); // stepKey: dontSeeProductNameDontSeeProduct2
		$I->comment("Exiting Action Group [dontSeeProduct2] AssertStorefrontProductNameIsNotOnProductMainPageActionGroup");
		$I->comment("Assert that product2 is not present in the search result");
		$I->comment("Entering Action Group [dontSeeProduct3] AssertStorefrontProductNameIsNotOnProductMainPageActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForTheProductPageToLoadDontSeeProduct3
		$I->dontSee($I->retrieveEntityField('product3', 'name', 'test'), ".product-item-name"); // stepKey: dontSeeProductNameDontSeeProduct3
		$I->comment("Exiting Action Group [dontSeeProduct3] AssertStorefrontProductNameIsNotOnProductMainPageActionGroup");
		$I->comment("Assert that product4 is present in the search result");
		$I->comment("Entering Action Group [seeProduct4] StorefrontAssertProductNameOnProductMainPageActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForTheProductPageToLoadSeeProduct4
		$I->see($I->retrieveEntityField('product4', 'name', 'test'), ".product-item-name"); // stepKey: seeProductNameSeeProduct4
		$I->comment("Exiting Action Group [seeProduct4] StorefrontAssertProductNameOnProductMainPageActionGroup");
		$I->comment("Assert that product5 is not present in the search result");
		$I->comment("Entering Action Group [dontSeeProduct5] AssertStorefrontProductNameIsNotOnProductMainPageActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForTheProductPageToLoadDontSeeProduct5
		$I->dontSee($I->retrieveEntityField('product5', 'name', 'test'), ".product-item-name"); // stepKey: dontSeeProductNameDontSeeProduct5
		$I->comment("Exiting Action Group [dontSeeProduct5] AssertStorefrontProductNameIsNotOnProductMainPageActionGroup");
		$I->comment("Assert that product6 is not present in the search result");
		$I->comment("Entering Action Group [dontSeeProduct6] AssertStorefrontProductNameIsNotOnProductMainPageActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForTheProductPageToLoadDontSeeProduct6
		$I->dontSee($I->retrieveEntityField('product6', 'name', 'test'), ".product-item-name"); // stepKey: dontSeeProductNameDontSeeProduct6
		$I->comment("Exiting Action Group [dontSeeProduct6] AssertStorefrontProductNameIsNotOnProductMainPageActionGroup");
		$I->comment("Search for word \"5127A\"");
		$I->comment("Entering Action Group [search2] StorefrontCheckQuickSearchStringActionGroup");
		$I->fillField("#search", "5127A"); // stepKey: fillInputSearch2
		$I->submitForm("#search", []); // stepKey: submitQuickSearchSearch2
		$I->seeInCurrentUrl("/catalogsearch/result/"); // stepKey: checkUrlSearch2
		$I->dontSeeInCurrentUrl("form_key="); // stepKey: checkUrlFormKeySearch2
		$I->seeInTitle("Search results for: '5127A'"); // stepKey: assertQuickSearchTitleSearch2
		$I->see("Search results for: '5127A'", ".page-title span"); // stepKey: assertQuickSearchNameSearch2
		$I->comment("Exiting Action Group [search2] StorefrontCheckQuickSearchStringActionGroup");
		$I->comment("Assert that product1 is not present in the search result");
		$I->comment("Entering Action Group [dontSeeProduct1] AssertStorefrontProductNameIsNotOnProductMainPageActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForTheProductPageToLoadDontSeeProduct1
		$I->dontSee($I->retrieveEntityField('product1', 'name', 'test'), ".product-item-name"); // stepKey: dontSeeProductNameDontSeeProduct1
		$I->comment("Exiting Action Group [dontSeeProduct1] AssertStorefrontProductNameIsNotOnProductMainPageActionGroup");
		$I->comment("Assert that product2 is present in the search result");
		$I->comment("Entering Action Group [seeProduct2] StorefrontAssertProductNameOnProductMainPageActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForTheProductPageToLoadSeeProduct2
		$I->see($I->retrieveEntityField('product2', 'name', 'test'), ".product-item-name"); // stepKey: seeProductNameSeeProduct2
		$I->comment("Exiting Action Group [seeProduct2] StorefrontAssertProductNameOnProductMainPageActionGroup");
		$I->comment("Assert that product3 is present in the search result");
		$I->comment("Entering Action Group [seeProduct3] StorefrontAssertProductNameOnProductMainPageActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForTheProductPageToLoadSeeProduct3
		$I->see($I->retrieveEntityField('product3', 'name', 'test'), ".product-item-name"); // stepKey: seeProductNameSeeProduct3
		$I->comment("Exiting Action Group [seeProduct3] StorefrontAssertProductNameOnProductMainPageActionGroup");
		$I->comment("Assert that product4 is not present in the search result");
		$I->comment("Entering Action Group [dontSeeProduct4] AssertStorefrontProductNameIsNotOnProductMainPageActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForTheProductPageToLoadDontSeeProduct4
		$I->dontSee($I->retrieveEntityField('product4', 'name', 'test'), ".product-item-name"); // stepKey: dontSeeProductNameDontSeeProduct4
		$I->comment("Exiting Action Group [dontSeeProduct4] AssertStorefrontProductNameIsNotOnProductMainPageActionGroup");
		$I->comment("Assert that product5 is present in the search result");
		$I->comment("Entering Action Group [seeProduct5] StorefrontAssertProductNameOnProductMainPageActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForTheProductPageToLoadSeeProduct5
		$I->see($I->retrieveEntityField('product5', 'name', 'test'), ".product-item-name"); // stepKey: seeProductNameSeeProduct5
		$I->comment("Exiting Action Group [seeProduct5] StorefrontAssertProductNameOnProductMainPageActionGroup");
		$I->comment("Assert that product6 is present in the search result");
		$I->comment("Entering Action Group [seeProduct6] StorefrontAssertProductNameOnProductMainPageActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForTheProductPageToLoadSeeProduct6
		$I->see($I->retrieveEntityField('product6', 'name', 'test'), ".product-item-name"); // stepKey: seeProductNameSeeProduct6
		$I->comment("Exiting Action Group [seeProduct6] StorefrontAssertProductNameOnProductMainPageActionGroup");
		$I->comment("Search for word \"5127SS\"");
		$I->comment("Entering Action Group [search3] StorefrontCheckQuickSearchStringActionGroup");
		$I->fillField("#search", "5127SS"); // stepKey: fillInputSearch3
		$I->submitForm("#search", []); // stepKey: submitQuickSearchSearch3
		$I->seeInCurrentUrl("/catalogsearch/result/"); // stepKey: checkUrlSearch3
		$I->dontSeeInCurrentUrl("form_key="); // stepKey: checkUrlFormKeySearch3
		$I->seeInTitle("Search results for: '5127SS'"); // stepKey: assertQuickSearchTitleSearch3
		$I->see("Search results for: '5127SS'", ".page-title span"); // stepKey: assertQuickSearchNameSearch3
		$I->comment("Exiting Action Group [search3] StorefrontCheckQuickSearchStringActionGroup");
		$I->comment("Assert that product1 is present in the search result");
		$I->comment("Entering Action Group [seeProduct1b] StorefrontAssertProductNameOnProductMainPageActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForTheProductPageToLoadSeeProduct1b
		$I->see($I->retrieveEntityField('product1', 'name', 'test'), ".product-item-name"); // stepKey: seeProductNameSeeProduct1b
		$I->comment("Exiting Action Group [seeProduct1b] StorefrontAssertProductNameOnProductMainPageActionGroup");
		$I->comment("Assert that product2 is not present in the search result");
		$I->comment("Entering Action Group [dontSeeProduct2b] AssertStorefrontProductNameIsNotOnProductMainPageActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForTheProductPageToLoadDontSeeProduct2b
		$I->dontSee($I->retrieveEntityField('product2', 'name', 'test'), ".product-item-name"); // stepKey: dontSeeProductNameDontSeeProduct2b
		$I->comment("Exiting Action Group [dontSeeProduct2b] AssertStorefrontProductNameIsNotOnProductMainPageActionGroup");
		$I->comment("Assert that product3 is not present in the search result");
		$I->comment("Entering Action Group [dontSeeProduct3b] AssertStorefrontProductNameIsNotOnProductMainPageActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForTheProductPageToLoadDontSeeProduct3b
		$I->dontSee($I->retrieveEntityField('product3', 'name', 'test'), ".product-item-name"); // stepKey: dontSeeProductNameDontSeeProduct3b
		$I->comment("Exiting Action Group [dontSeeProduct3b] AssertStorefrontProductNameIsNotOnProductMainPageActionGroup");
		$I->comment("Assert that product4 is present in the search result");
		$I->comment("Entering Action Group [seeProduct4b] StorefrontAssertProductNameOnProductMainPageActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForTheProductPageToLoadSeeProduct4b
		$I->see($I->retrieveEntityField('product4', 'name', 'test'), ".product-item-name"); // stepKey: seeProductNameSeeProduct4b
		$I->comment("Exiting Action Group [seeProduct4b] StorefrontAssertProductNameOnProductMainPageActionGroup");
		$I->comment("Assert that product5 is not present in the search result");
		$I->comment("Entering Action Group [dontSeeProduct5b] AssertStorefrontProductNameIsNotOnProductMainPageActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForTheProductPageToLoadDontSeeProduct5b
		$I->dontSee($I->retrieveEntityField('product5', 'name', 'test'), ".product-item-name"); // stepKey: dontSeeProductNameDontSeeProduct5b
		$I->comment("Exiting Action Group [dontSeeProduct5b] AssertStorefrontProductNameIsNotOnProductMainPageActionGroup");
		$I->comment("Assert that product6 is not present in the search result");
		$I->comment("Entering Action Group [dontSeeProduct6b] AssertStorefrontProductNameIsNotOnProductMainPageActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForTheProductPageToLoadDontSeeProduct6b
		$I->dontSee($I->retrieveEntityField('product6', 'name', 'test'), ".product-item-name"); // stepKey: dontSeeProductNameDontSeeProduct6b
		$I->comment("Exiting Action Group [dontSeeProduct6b] AssertStorefrontProductNameIsNotOnProductMainPageActionGroup");
	}
}
