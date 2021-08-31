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
 * @Title("MC-14794: User should not get search results on query that only contains two characters")
 * @Description("Use of 2 character query to return no products<h3>Test files</h3>app/code/Magento/CatalogSearch/Test/Mftf/Test/SearchEntityResultsTest/QuickSearchWithTwoCharsEmptyResultsTest.xml<br>")
 * @TestCaseId("MC-14794")
 * @group CatalogSearch
 * @group mtf_migrated
 */
class QuickSearchWithTwoCharsEmptyResultsTestCest
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
		$I->createEntity("createCategory", "hook", "_defaultCategory", [], []); // stepKey: createCategory
		$I->createEntity("createSimpleProduct", "hook", "_defaultProduct", ["createCategory"], []); // stepKey: createSimpleProduct
		$setMinimalQueryLengthToFour = $I->magentoCLI("config:set catalog/search/min_query_length 4", 60); // stepKey: setMinimalQueryLengthToFour
		$I->comment($setMinimalQueryLengthToFour);
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
		$I->deleteEntity("createSimpleProduct", "hook"); // stepKey: deleteProduct
		$I->deleteEntity("createCategory", "hook"); // stepKey: deleteCategory
		$setMinimalQueryLengthToFour = $I->magentoCLI("config:set catalog/search/min_query_length 3", 60); // stepKey: setMinimalQueryLengthToFour
		$I->comment($setMinimalQueryLengthToFour);
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
	 * @Stories({"Search Product on Storefront"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function QuickSearchWithTwoCharsEmptyResultsTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [goToFrontPage] StorefrontOpenHomePageActionGroup");
		$I->amOnPage("/"); // stepKey: goToStorefrontPageGoToFrontPage
		$I->waitForPageLoad(30); // stepKey: waitForStorefrontPageLoadGoToFrontPage
		$I->comment("Exiting Action Group [goToFrontPage] StorefrontOpenHomePageActionGroup");
		$getFirstLessThenConfigLetters = $I->executeJS("var s = '" . $I->retrieveEntityField('createSimpleProduct', 'name', 'test') . "'; var ret=s.substring(0,4 - 1); return ret;"); // stepKey: getFirstLessThenConfigLetters
		$I->comment("Entering Action Group [searchStorefront] StorefrontCheckQuickSearchStringActionGroup");
		$I->fillField("#search", "ThisShouldn'tReturnAnything"); // stepKey: fillInputSearchStorefront
		$I->submitForm("#search", []); // stepKey: submitQuickSearchSearchStorefront
		$I->seeInCurrentUrl("/catalogsearch/result/"); // stepKey: checkUrlSearchStorefront
		$I->dontSeeInCurrentUrl("form_key="); // stepKey: checkUrlFormKeySearchStorefront
		$I->seeInTitle("Search results for: 'ThisShouldn'tReturnAnything'"); // stepKey: assertQuickSearchTitleSearchStorefront
		$I->see("Search results for: 'ThisShouldn'tReturnAnything'", ".page-title span"); // stepKey: assertQuickSearchNameSearchStorefront
		$I->comment("Exiting Action Group [searchStorefront] StorefrontCheckQuickSearchStringActionGroup");
		$I->comment("Entering Action Group [checkEmpty] StorefrontCheckSearchIsEmptyActionGroup");
		$I->see("Your search returned no results", "div .message"); // stepKey: checkEmptyCheckEmpty
		$I->comment("Exiting Action Group [checkEmpty] StorefrontCheckSearchIsEmptyActionGroup");
		$I->comment("Entering Action Group [searchStorefrontConfigLetters] StorefrontCheckQuickSearchStringActionGroup");
		$I->fillField("#search", $I->retrieveEntityField('createSimpleProduct', 'name', 'test')); // stepKey: fillInputSearchStorefrontConfigLetters
		$I->submitForm("#search", []); // stepKey: submitQuickSearchSearchStorefrontConfigLetters
		$I->seeInCurrentUrl("/catalogsearch/result/"); // stepKey: checkUrlSearchStorefrontConfigLetters
		$I->dontSeeInCurrentUrl("form_key="); // stepKey: checkUrlFormKeySearchStorefrontConfigLetters
		$I->seeInTitle("Search results for: '" . $I->retrieveEntityField('createSimpleProduct', 'name', 'test') . "'"); // stepKey: assertQuickSearchTitleSearchStorefrontConfigLetters
		$I->see("Search results for: '" . $I->retrieveEntityField('createSimpleProduct', 'name', 'test') . "'", ".page-title span"); // stepKey: assertQuickSearchNameSearchStorefrontConfigLetters
		$I->comment("Exiting Action Group [searchStorefrontConfigLetters] StorefrontCheckQuickSearchStringActionGroup");
		$I->comment("Entering Action Group [checkCannotSearchWithTooShortString] StorefrontQuickSearchTooShortStringActionGroup");
		$I->fillField("#search", "$getFirstLessThenConfigLetters"); // stepKey: fillInputCheckCannotSearchWithTooShortString
		$I->submitForm("#search", []); // stepKey: submitQuickSearchCheckCannotSearchWithTooShortString
		$I->seeInCurrentUrl("/catalogsearch/result/"); // stepKey: checkUrlCheckCannotSearchWithTooShortString
		$I->dontSeeInCurrentUrl("form_key="); // stepKey: checkUrlFormKeyCheckCannotSearchWithTooShortString
		$I->seeInTitle("Search results for: '$getFirstLessThenConfigLetters'"); // stepKey: assertQuickSearchTitleCheckCannotSearchWithTooShortString
		$I->see("Search results for: '$getFirstLessThenConfigLetters'", ".page-title span"); // stepKey: assertQuickSearchNameCheckCannotSearchWithTooShortString
		$I->see("Minimum Search query length is 4", "div .message"); // stepKey: assertQuickSearchNeedThreeOrMoreCharsCheckCannotSearchWithTooShortString
		$I->comment("Exiting Action Group [checkCannotSearchWithTooShortString] StorefrontQuickSearchTooShortStringActionGroup");
		$I->comment("Entering Action Group [checkRelatedSearchTerm] StorefrontQuickSearchRelatedSearchTermsAppearsActionGroup");
		$I->waitForElementVisible("div.message dl.block dt.title", 30); // stepKey: waitMessageAppearsCheckRelatedSearchTerm
		$I->see("Related search terms", "div.message dl.block dt.title"); // stepKey: checkRelatedTermsTitleCheckRelatedSearchTerm
		$I->see($I->retrieveEntityField('createSimpleProduct', 'name', 'test'), "div.message dl.block dd.item a"); // stepKey: checkRelatedTermExistsCheckRelatedSearchTerm
		$I->comment("Exiting Action Group [checkRelatedSearchTerm] StorefrontQuickSearchRelatedSearchTermsAppearsActionGroup");
	}
}
