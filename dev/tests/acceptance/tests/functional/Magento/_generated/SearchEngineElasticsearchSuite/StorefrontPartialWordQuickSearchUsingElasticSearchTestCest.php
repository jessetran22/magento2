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
 * @Title("MC-34205: Support partial word search in Elasticsearch")
 * @Description("Support quick search with Partial word search using ES<h3>Test files</h3>app/code/Magento/CatalogSearch/Test/Mftf/Test/StorefrontPartialWordQuickSearchUsingElasticSearchTest.xml<br>")
 * @TestCaseId("MC-34205")
 * @group SearchEngineElasticsearch
 */
class StorefrontPartialWordQuickSearchUsingElasticSearchTestCest
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
		$I->comment("Create subcategory");
		$I->createEntity("newCategory", "hook", "SimpleSubCategory", [], []); // stepKey: newCategory
		$I->createEntity("product1", "hook", "ProductForPartialSearch", ["newCategory"], []); // stepKey: product1
		$I->createEntity("product2", "hook", "ApiSimpleProduct", ["newCategory"], []); // stepKey: product2
		$I->createEntity("product3", "hook", "ApiSimpleProductWithNoSpace", ["newCategory"], []); // stepKey: product3
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->deleteEntity("product1", "hook"); // stepKey: deleteProduct1
		$I->deleteEntity("product2", "hook"); // stepKey: deleteProduct2
		$I->deleteEntity("product3", "hook"); // stepKey: deleteProduct3
		$I->deleteEntity("newCategory", "hook"); // stepKey: deleteCategory
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
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StorefrontPartialWordQuickSearchUsingElasticSearchTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [goToHomePage] StorefrontOpenHomePageActionGroup");
		$I->amOnPage("/"); // stepKey: goToStorefrontPageGoToHomePage
		$I->waitForPageLoad(30); // stepKey: waitForStorefrontPageLoadGoToHomePage
		$I->comment("Exiting Action Group [goToHomePage] StorefrontOpenHomePageActionGroup");
		$I->comment("Perform a quick seach using a partial word from product SKU");
		$I->comment("Entering Action Group [quickSearchPartialSku] StorefrontCheckQuickSearchStringActionGroup");
		$I->fillField("#search", "partial"); // stepKey: fillInputQuickSearchPartialSku
		$I->submitForm("#search", []); // stepKey: submitQuickSearchQuickSearchPartialSku
		$I->seeInCurrentUrl("/catalogsearch/result/"); // stepKey: checkUrlQuickSearchPartialSku
		$I->dontSeeInCurrentUrl("form_key="); // stepKey: checkUrlFormKeyQuickSearchPartialSku
		$I->seeInTitle("Search results for: 'partial'"); // stepKey: assertQuickSearchTitleQuickSearchPartialSku
		$I->see("Search results for: 'partial'", ".page-title span"); // stepKey: assertQuickSearchNameQuickSearchPartialSku
		$I->comment("Exiting Action Group [quickSearchPartialSku] StorefrontCheckQuickSearchStringActionGroup");
		$I->comment("Perform a case insensitive quick search of partial word using case product name");
		$I->comment("Entering Action Group [quickSearchPartialCaseInSensitive] StorefrontCheckQuickSearchStringActionGroup");
		$I->fillField("#search", "simple"); // stepKey: fillInputQuickSearchPartialCaseInSensitive
		$I->submitForm("#search", []); // stepKey: submitQuickSearchQuickSearchPartialCaseInSensitive
		$I->seeInCurrentUrl("/catalogsearch/result/"); // stepKey: checkUrlQuickSearchPartialCaseInSensitive
		$I->dontSeeInCurrentUrl("form_key="); // stepKey: checkUrlFormKeyQuickSearchPartialCaseInSensitive
		$I->seeInTitle("Search results for: 'simple'"); // stepKey: assertQuickSearchTitleQuickSearchPartialCaseInSensitive
		$I->see("Search results for: 'simple'", ".page-title span"); // stepKey: assertQuickSearchNameQuickSearchPartialCaseInSensitive
		$I->comment("Exiting Action Group [quickSearchPartialCaseInSensitive] StorefrontCheckQuickSearchStringActionGroup");
		$I->comment("Perform a quick search using parts of the words from name/sku with additional characters");
		$I->comment("Entering Action Group [quickSearchPartialWordsWithExtraChars] StorefrontCheckQuickSearchStringActionGroup");
		$I->fillField("#search", "barstool"); // stepKey: fillInputQuickSearchPartialWordsWithExtraChars
		$I->submitForm("#search", []); // stepKey: submitQuickSearchQuickSearchPartialWordsWithExtraChars
		$I->seeInCurrentUrl("/catalogsearch/result/"); // stepKey: checkUrlQuickSearchPartialWordsWithExtraChars
		$I->dontSeeInCurrentUrl("form_key="); // stepKey: checkUrlFormKeyQuickSearchPartialWordsWithExtraChars
		$I->seeInTitle("Search results for: 'barstool'"); // stepKey: assertQuickSearchTitleQuickSearchPartialWordsWithExtraChars
		$I->see("Search results for: 'barstool'", ".page-title span"); // stepKey: assertQuickSearchNameQuickSearchPartialWordsWithExtraChars
		$I->comment("Exiting Action Group [quickSearchPartialWordsWithExtraChars] StorefrontCheckQuickSearchStringActionGroup");
		$I->comment("Entering Action Group [checkEmptySearchResult] StorefrontCheckSearchIsEmptyActionGroup");
		$I->see("Your search returned no results", "div .message"); // stepKey: checkEmptyCheckEmptySearchResult
		$I->comment("Exiting Action Group [checkEmptySearchResult] StorefrontCheckSearchIsEmptyActionGroup");
	}
}
