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
 * @Title("MC-6325: Minimal query length for catalog search")
 * @Description("Minimal query length for catalog search<h3>Test files</h3>app/code/Magento/CatalogSearch/Test/Mftf/Test/MinimalQueryLengthForCatalogSearchTest.xml<br>")
 * @TestCaseId("MC-6325")
 * @group CatalogSearch
 * @group SearchEngineElasticsearch
 */
class MinimalQueryLengthForCatalogSearchTestCest
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
		$I->createEntity("createCategory", "hook", "ApiCategory", [], []); // stepKey: createCategory
		$I->createEntity("createProduct", "hook", "productAlphabeticalB", ["createCategory"], []); // stepKey: createProduct
		$I->comment("Entering Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdminWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin
		$I->comment("Exiting Action Group [loginAsAdmin] AdminLoginActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->deleteEntity("createCategory", "hook"); // stepKey: deleteCategory
		$I->deleteEntity("createProduct", "hook"); // stepKey: deleteProduct
		$I->createEntity("setMinimumQueryLengthToDefault", "hook", "SetMinQueryLengthToDefault", [], []); // stepKey: setMinimumQueryLengthToDefault
		$I->comment("Entering Action Group [logout] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogout
		$I->comment("Exiting Action Group [logout] AdminLogoutActionGroup");
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
	 * @Stories({"Catalog search"})
	 * @Severity(level = SeverityLevel::MINOR)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function MinimalQueryLengthForCatalogSearchTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [setMinQueryLength] SetMinimalQueryLengthActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_config/edit/section/catalog/"); // stepKey: navigateToConfigurationPageSetMinQueryLength
		$I->waitForPageLoad(30); // stepKey: wait1SetMinQueryLength
		$I->scrollTo("a#catalog_search-head"); // stepKey: scrollToCatalogSearchTabSetMinQueryLength
		$I->conditionalClick("a#catalog_search-head", "#catalog_search_min_query_length", false); // stepKey: expandCatalogSearchTabSetMinQueryLength
		$I->waitForElementVisible("#catalog_search_min_query_length", 30); // stepKey: waitTabToCollapseSetMinQueryLength
		$I->see("This value must be compatible with the corresponding setting in the configured search engine", "#row_catalog_search_min_query_length .value span"); // stepKey: seeHint1SetMinQueryLength
		$I->see("This value must be compatible with the corresponding setting in the configured search engine", "#row_catalog_search_max_query_length .value span"); // stepKey: seeHint2SetMinQueryLength
		$I->uncheckOption("#catalog_search_min_query_length_inherit"); // stepKey: uncheckSystemValueSetMinQueryLength
		$I->fillField("#catalog_search_min_query_length", "1"); // stepKey: setMinQueryLengthSetMinQueryLength
		$I->click("#save"); // stepKey: saveConfigSetMinQueryLength
		$I->waitForPageLoad(30); // stepKey: saveConfigSetMinQueryLengthWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForConfigSavedSetMinQueryLength
		$I->see("You saved the configuration."); // stepKey: seeSuccessMessageSetMinQueryLength
		$I->comment("Exiting Action Group [setMinQueryLength] SetMinimalQueryLengthActionGroup");
		$I->comment("Go to Storefront and search for product");
		$I->comment("Entering Action Group [goToHomePage] StorefrontOpenHomePageActionGroup");
		$I->amOnPage("/"); // stepKey: goToStorefrontPageGoToHomePage
		$I->waitForPageLoad(30); // stepKey: waitForStorefrontPageLoadGoToHomePage
		$I->comment("Exiting Action Group [goToHomePage] StorefrontOpenHomePageActionGroup");
		$I->comment("Quick search by single character and avoid using ES stopwords");
		$I->comment("Entering Action Group [fillAttribute] StorefrontCheckQuickSearchStringActionGroup");
		$I->fillField("#search", "B"); // stepKey: fillInputFillAttribute
		$I->submitForm("#search", []); // stepKey: submitQuickSearchFillAttribute
		$I->seeInCurrentUrl("/catalogsearch/result/"); // stepKey: checkUrlFillAttribute
		$I->dontSeeInCurrentUrl("form_key="); // stepKey: checkUrlFormKeyFillAttribute
		$I->seeInTitle("Search results for: 'B'"); // stepKey: assertQuickSearchTitleFillAttribute
		$I->see("Search results for: 'B'", ".page-title span"); // stepKey: assertQuickSearchNameFillAttribute
		$I->comment("Exiting Action Group [fillAttribute] StorefrontCheckQuickSearchStringActionGroup");
		$I->comment("Comment is added to preserve the step key for backward compatibility");
		$I->comment("Comment is added to preserve the step key for backward compatibility");
		$I->comment("Comment is added to preserve the step key for backward compatibility");
		$I->comment("Entering Action Group [seeProductNameInCategoryPage] StorefrontAssertProductNameOnProductMainPageActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForTheProductPageToLoadSeeProductNameInCategoryPage
		$I->see($I->retrieveEntityField('createProduct', 'name', 'test'), ".product-item-name"); // stepKey: seeProductNameSeeProductNameInCategoryPage
		$I->comment("Exiting Action Group [seeProductNameInCategoryPage] StorefrontAssertProductNameOnProductMainPageActionGroup");
	}
}
