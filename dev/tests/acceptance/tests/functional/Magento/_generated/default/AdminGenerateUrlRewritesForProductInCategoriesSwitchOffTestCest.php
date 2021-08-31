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
 * @Title("MC-16330: Clear Url Rewrites after configuration turned off")
 * @Description("Check Url Rewrites for product in categories is correctly cleared after configuration turned off<h3>Test files</h3>app/code/Magento/UrlRewrite/Test/Mftf/Test/AdminGenerateUrlRewritesForProductInCategoriesSwitchOffTest.xml<br>")
 * @TestCaseId("MC-16330")
 * @group urlRewrite
 */
class AdminGenerateUrlRewritesForProductInCategoriesSwitchOffTestCest
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
		$I->comment("Set the configuration for Generate \"category/product\" URL Rewrites");
		$I->comment("Enable config to generate category/product URL Rewrites");
		$enableGenerateUrlRewrite = $I->magentoCLI("config:set catalog/seo/generate_category_product_rewrites 1", 60); // stepKey: enableGenerateUrlRewrite
		$I->comment($enableGenerateUrlRewrite);
		$I->comment("Adding the comment to replace CliCacheFlushActionGroup action group ('cache:flush' command) for preserving Backward Compatibility");
		$I->comment("Entering Action Group [login] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLogin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLogin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLogin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLogin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLogin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLogin
		$I->comment("Exiting Action Group [login] AdminLoginActionGroup");
		$I->createEntity("createCategory", "hook", "SimpleSubCategory", [], []); // stepKey: createCategory
		$I->createEntity("createSimpleProduct", "hook", "SimpleProduct", ["createCategory"], []); // stepKey: createSimpleProduct
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->deleteEntity("createCategory", "hook"); // stepKey: deleteCategory
		$I->deleteEntity("createSimpleProduct", "hook"); // stepKey: deleteProduct
		$I->comment("Set the configuration for Generate \"category/product\" URL Rewrites");
		$I->comment("Enable config to generate category/product URL Rewrites");
		$enableGenerateUrlRewrite = $I->magentoCLI("config:set catalog/seo/generate_category_product_rewrites 1", 60); // stepKey: enableGenerateUrlRewrite
		$I->comment($enableGenerateUrlRewrite);
		$I->comment("Adding the comment to replace CliCacheFlushActionGroup action group ('cache:flush' command) for preserving Backward Compatibility");
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
	 * @Features({"UrlRewrite"})
	 * @Stories({"Url Rewrites cleared in case of switching configuration off"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminGenerateUrlRewritesForProductInCategoriesSwitchOffTest(AcceptanceTester $I)
	{
		$I->comment("1. Open Marketing - SEO & Search - URL Rewrites");
		$I->comment("Entering Action Group [searchingUrlRewrite] AdminSearchUrlRewriteByRequestPathActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/url_rewrite/index/"); // stepKey: openUrlRewriteEditPageSearchingUrlRewrite
		$I->waitForPageLoad(30); // stepKey: waitForUrlRewriteEditPageToLoadSearchingUrlRewrite
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersSearchingUrlRewrite
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersSearchingUrlRewriteWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadSearchingUrlRewrite
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openUrlRewriteGridFiltersSearchingUrlRewrite
		$I->waitForPageLoad(30); // stepKey: openUrlRewriteGridFiltersSearchingUrlRewriteWaitForPageLoad
		$I->fillField(".admin__data-grid-filters input[name='request_path']", $I->retrieveEntityField('createSimpleProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: fillRequestPathFilterSearchingUrlRewrite
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickOrderApplyFiltersSearchingUrlRewrite
		$I->waitForPageLoad(30); // stepKey: clickOrderApplyFiltersSearchingUrlRewriteWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoad1SearchingUrlRewrite
		$I->comment("Exiting Action Group [searchingUrlRewrite] AdminSearchUrlRewriteByRequestPathActionGroup");
		$I->comment("Entering Action Group [seeProductUrlInGrid] AssertAdminRequestPathInUrlRewriteGrigActionGroup");
		$I->seeElement("//*[@data-role='grid']//tbody//td[count(//*[@data-role='grid']//th[contains(., 'Request Path')]/preceding-sibling::th)+1][normalize-space(.)='" . $I->retrieveEntityField('createSimpleProduct', 'custom_attributes[url_key]', 'test') . ".html']"); // stepKey: seeValueInGridSeeProductUrlInGrid
		$I->comment("Exiting Action Group [seeProductUrlInGrid] AssertAdminRequestPathInUrlRewriteGrigActionGroup");
		$I->comment("Entering Action Group [seeCategoryUrlInGrid] AssertAdminRequestPathInUrlRewriteGrigActionGroup");
		$I->seeElement("//*[@data-role='grid']//tbody//td[count(//*[@data-role='grid']//th[contains(., 'Request Path')]/preceding-sibling::th)+1][normalize-space(.)='" . $I->retrieveEntityField('createCategory', 'custom_attributes[url_key]', 'test') . "/" . $I->retrieveEntityField('createSimpleProduct', 'custom_attributes[url_key]', 'test') . ".html']"); // stepKey: seeValueInGridSeeCategoryUrlInGrid
		$I->comment("Exiting Action Group [seeCategoryUrlInGrid] AssertAdminRequestPathInUrlRewriteGrigActionGroup");
		$I->comment("2. Set the configuration for Generate \"category/product\" URL Rewrites to No");
		$disableGenerateUrlRewrite = $I->magentoCLI("config:set catalog/seo/generate_category_product_rewrites 0", 60); // stepKey: disableGenerateUrlRewrite
		$I->comment($disableGenerateUrlRewrite);
		$I->comment("3. Flush cache");
		$I->comment("Adding the comment to replace CliCacheFlushActionGroup action group ('cache:flush' command) for preserving Backward Compatibility");
		$I->comment("4. Open Marketing - SEO & Search - URL Rewrites");
		$I->comment("Entering Action Group [searchingUrlRewriteAfterDisablingTheConfig] AdminSearchUrlRewriteByRequestPathActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/url_rewrite/index/"); // stepKey: openUrlRewriteEditPageSearchingUrlRewriteAfterDisablingTheConfig
		$I->waitForPageLoad(30); // stepKey: waitForUrlRewriteEditPageToLoadSearchingUrlRewriteAfterDisablingTheConfig
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersSearchingUrlRewriteAfterDisablingTheConfig
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersSearchingUrlRewriteAfterDisablingTheConfigWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadSearchingUrlRewriteAfterDisablingTheConfig
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openUrlRewriteGridFiltersSearchingUrlRewriteAfterDisablingTheConfig
		$I->waitForPageLoad(30); // stepKey: openUrlRewriteGridFiltersSearchingUrlRewriteAfterDisablingTheConfigWaitForPageLoad
		$I->fillField(".admin__data-grid-filters input[name='request_path']", $I->retrieveEntityField('createSimpleProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: fillRequestPathFilterSearchingUrlRewriteAfterDisablingTheConfig
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickOrderApplyFiltersSearchingUrlRewriteAfterDisablingTheConfig
		$I->waitForPageLoad(30); // stepKey: clickOrderApplyFiltersSearchingUrlRewriteAfterDisablingTheConfigWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoad1SearchingUrlRewriteAfterDisablingTheConfig
		$I->comment("Exiting Action Group [searchingUrlRewriteAfterDisablingTheConfig] AdminSearchUrlRewriteByRequestPathActionGroup");
		$I->comment("Entering Action Group [seeProductUrlInGridAfterDisablingTheConfig] AssertAdminRequestPathInUrlRewriteGrigActionGroup");
		$I->seeElement("//*[@data-role='grid']//tbody//td[count(//*[@data-role='grid']//th[contains(., 'Request Path')]/preceding-sibling::th)+1][normalize-space(.)='" . $I->retrieveEntityField('createSimpleProduct', 'custom_attributes[url_key]', 'test') . ".html']"); // stepKey: seeValueInGridSeeProductUrlInGridAfterDisablingTheConfig
		$I->comment("Exiting Action Group [seeProductUrlInGridAfterDisablingTheConfig] AssertAdminRequestPathInUrlRewriteGrigActionGroup");
		$I->comment("Entering Action Group [categoryUrlIsNotShownAfterDisablingTheConfig] AssertAdminRequestPathIsNotFoundInUrlRewriteGrigActionGroup");
		$I->dontSeeElement("//*[@data-role='grid']//tbody//td[count(//*[@data-role='grid']//th[contains(., 'Request Path')]/preceding-sibling::th)+1][normalize-space(.)='" . $I->retrieveEntityField('createCategory', 'custom_attributes[url_key]', 'test') . "/" . $I->retrieveEntityField('createSimpleProduct', 'custom_attributes[url_key]', 'test') . ".html']"); // stepKey: valueIsNotShownInGridCategoryUrlIsNotShownAfterDisablingTheConfig
		$I->comment("Exiting Action Group [categoryUrlIsNotShownAfterDisablingTheConfig] AssertAdminRequestPathIsNotFoundInUrlRewriteGrigActionGroup");
	}
}
