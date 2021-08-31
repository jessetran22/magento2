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
 * @Title("MC-6310: Elastic search for Chinese locale")
 * @Description("Elastic search for Chinese locale<h3>Test files</h3>app/code/Magento/Elasticsearch6/Test/Mftf/Test/StorefrontElasticSearchForChineseLocaleTest.xml<br>")
 * @TestCaseId("MC-6310")
 * @group elasticsearch
 * @group SearchEngineElasticsearch
 */
class StorefrontElasticSearchForChineseLocaleTestCest
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
		$I->comment("Set search engine to Elastic, set Locale to China, create category and product, then go to Storefront");
		$I->comment("Entering Action Group [login] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLogin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLogin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLogin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLogin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLogin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLogin
		$I->comment("Exiting Action Group [login] AdminLoginActionGroup");
		$setLocaleToChina = $I->magentoCLI("config:set --scope=websites --scope-code=base general/locale/code zh_Hans_CN", 60); // stepKey: setLocaleToChina
		$I->comment($setLocaleToChina);
		$I->comment("Moved to appropriate test suite");
		$I->comment("Moved to appropriate test suite");
		$I->comment("Adding the comment to replace CliCacheFlushActionGroup action group ('cache:flush' command) for preserving Backward Compatibility");
		$I->createEntity("createCategory", "hook", "ApiCategory", [], []); // stepKey: createCategory
		$I->createEntity("createProduct", "hook", "ApiSimpleProduct", ["createCategory"], []); // stepKey: createProduct
		$I->comment("Entering Action Group [openStoreFrontHomePage] StorefrontOpenHomePageActionGroup");
		$I->amOnPage("/"); // stepKey: goToStorefrontPageOpenStoreFrontHomePage
		$I->waitForPageLoad(30); // stepKey: waitForStorefrontPageLoadOpenStoreFrontHomePage
		$I->comment("Exiting Action Group [openStoreFrontHomePage] StorefrontOpenHomePageActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Delete created data and reset initial configuration");
		$setLocaleToUS = $I->magentoCLI("config:set --scope=websites --scope-code=base general/locale/code en_US", 60); // stepKey: setLocaleToUS
		$I->comment($setLocaleToUS);
		$I->comment("Moved to appropriate test suite");
		$I->deleteEntity("createCategory", "hook"); // stepKey: deleteCategory
		$I->deleteEntity("createProduct", "hook"); // stepKey: deleteSimpleProduct
		$I->comment("Entering Action Group [logoutOfAdmin] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogoutOfAdmin
		$I->comment("Exiting Action Group [logoutOfAdmin] AdminLogoutActionGroup");
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
	 * @Features({"Elasticsearch6"})
	 * @Stories({"Elasticsearch6 for Chinese"})
	 * @Severity(level = SeverityLevel::BLOCKER)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StorefrontElasticSearchForChineseLocaleTest(AcceptanceTester $I)
	{
		$I->comment("Search for product by name");
		$I->comment("Entering Action Group [quickSearchByProductName] StorefrontCheckQuickSearchStringActionGroup");
		$I->fillField("#search", $I->retrieveEntityField('createProduct', 'name', 'test')); // stepKey: fillInputQuickSearchByProductName
		$I->submitForm("#search", []); // stepKey: submitQuickSearchQuickSearchByProductName
		$I->seeInCurrentUrl("/catalogsearch/result/"); // stepKey: checkUrlQuickSearchByProductName
		$I->dontSeeInCurrentUrl("form_key="); // stepKey: checkUrlFormKeyQuickSearchByProductName
		$I->seeInTitle("Search results for: '" . $I->retrieveEntityField('createProduct', 'name', 'test') . "'"); // stepKey: assertQuickSearchTitleQuickSearchByProductName
		$I->see("Search results for: '" . $I->retrieveEntityField('createProduct', 'name', 'test') . "'", ".page-title span"); // stepKey: assertQuickSearchNameQuickSearchByProductName
		$I->comment("Exiting Action Group [quickSearchByProductName] StorefrontCheckQuickSearchStringActionGroup");
		$I->comment("Check if searched product is displayed");
		$I->see($I->retrieveEntityField('createProduct', 'name', 'test'), ".product-item-name"); // stepKey: seeProductNameInCategoryPage
	}
}
