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
 * @Title("MC-16681: Url-rewrites for product in anchor categories for all store views")
 * @Description("Verify that Saving category do not delete UrlRewrites for subcategories and all products in them.<h3>Test files</h3>app/code/Magento/UrlRewrite/Test/Mftf/Test/AdminUrlRewritesForProductInAnchorCategoriesTest/AdminUrlRewritesForProductInAnchorCategoriesTestAllStoreViewTest.xml<br>")
 * @TestCaseId("MC-16681")
 * @group urlRewrite
 */
class AdminUrlRewritesForProductInAnchorCategoriesTestAllStoreViewTestCest
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
		$I->createEntity("simpleSubCategory1", "hook", "SimpleSubCategory", [], []); // stepKey: simpleSubCategory1
		$I->createEntity("simpleSubCategory2", "hook", "SubCategoryWithParent", ["simpleSubCategory1"], []); // stepKey: simpleSubCategory2
		$I->createEntity("simpleSubCategory3", "hook", "SubCategoryWithParent", ["simpleSubCategory2"], []); // stepKey: simpleSubCategory3
		$I->createEntity("createSimpleProduct", "hook", "ApiSimpleProduct", ["simpleSubCategory1", "simpleSubCategory2", "simpleSubCategory3"], []); // stepKey: createSimpleProduct
		$I->comment("Create Simple product 1 and assign it to Category 3");
		$I->comment("Set the configuration for Generate \"category/product\" URL Rewrites");
		$I->comment("Enable config to generate category/product URL Rewrites ");
		$enableGenerateUrlRewrite = $I->magentoCLI("config:set catalog/seo/generate_category_product_rewrites 1", 60); // stepKey: enableGenerateUrlRewrite
		$I->comment($enableGenerateUrlRewrite);
		$I->comment("Create Simple product 1 and assign it to all the threee categories above");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->deleteEntity("createSimpleProduct", "hook"); // stepKey: deleteSimpleProduct
		$I->deleteEntity("simpleSubCategory1", "hook"); // stepKey: deletesimpleSubCategory1
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
	 * @Stories({"Url-rewrites for product in anchor categories for all store views"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminUrlRewritesForProductInAnchorCategoriesTestAllStoreViewTest(AcceptanceTester $I)
	{
		$I->comment("Preconditions");
		$I->comment("Create 3 categories");
		$I->comment("Steps");
		$I->comment("1. Log in to Admin");
		$I->comment("Entering Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdminWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin
		$I->comment("Exiting Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->comment("2. Open Marketing - SEO & Search - URL Rewrites");
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
		$I->comment("Entering Action Group [seeValueOne] AssertAdminRequestPathInUrlRewriteGrigActionGroup");
		$I->seeElement("//*[@data-role='grid']//tbody//td[count(//*[@data-role='grid']//th[contains(., 'Request Path')]/preceding-sibling::th)+1][normalize-space(.)='" . $I->retrieveEntityField('createSimpleProduct', 'custom_attributes[url_key]', 'test') . ".html']"); // stepKey: seeValueInGridSeeValueOne
		$I->comment("Exiting Action Group [seeValueOne] AssertAdminRequestPathInUrlRewriteGrigActionGroup");
		$I->comment("Entering Action Group [seeValueTwo] AssertAdminRequestPathInUrlRewriteGrigActionGroup");
		$I->seeElement("//*[@data-role='grid']//tbody//td[count(//*[@data-role='grid']//th[contains(., 'Request Path')]/preceding-sibling::th)+1][normalize-space(.)='" . $I->retrieveEntityField('simpleSubCategory1', 'custom_attributes[url_key]', 'test') . "/" . $I->retrieveEntityField('createSimpleProduct', 'custom_attributes[url_key]', 'test') . ".html']"); // stepKey: seeValueInGridSeeValueTwo
		$I->comment("Exiting Action Group [seeValueTwo] AssertAdminRequestPathInUrlRewriteGrigActionGroup");
		$I->comment("Entering Action Group [seeValueThree] AssertAdminRequestPathInUrlRewriteGrigActionGroup");
		$I->seeElement("//*[@data-role='grid']//tbody//td[count(//*[@data-role='grid']//th[contains(., 'Request Path')]/preceding-sibling::th)+1][normalize-space(.)='" . $I->retrieveEntityField('simpleSubCategory1', 'custom_attributes[url_key]', 'test') . "/" . $I->retrieveEntityField('simpleSubCategory2', 'custom_attributes[url_key]', 'test') . "/" . $I->retrieveEntityField('createSimpleProduct', 'custom_attributes[url_key]', 'test') . ".html']"); // stepKey: seeValueInGridSeeValueThree
		$I->comment("Exiting Action Group [seeValueThree] AssertAdminRequestPathInUrlRewriteGrigActionGroup");
		$I->comment("Entering Action Group [seeValueFour] AssertAdminRequestPathInUrlRewriteGrigActionGroup");
		$I->seeElement("//*[@data-role='grid']//tbody//td[count(//*[@data-role='grid']//th[contains(., 'Request Path')]/preceding-sibling::th)+1][normalize-space(.)='" . $I->retrieveEntityField('simpleSubCategory1', 'custom_attributes[url_key]', 'test') . "/" . $I->retrieveEntityField('simpleSubCategory2', 'custom_attributes[url_key]', 'test') . "/" . $I->retrieveEntityField('simpleSubCategory3', 'custom_attributes[url_key]', 'test') . "/" . $I->retrieveEntityField('createSimpleProduct', 'custom_attributes[url_key]', 'test') . ".html']"); // stepKey: seeValueInGridSeeValueFour
		$I->comment("Exiting Action Group [seeValueFour] AssertAdminRequestPathInUrlRewriteGrigActionGroup");
		$I->comment("Entering Action Group [goToCategoryPage] NavigateToCreatedCategoryActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/category/"); // stepKey: amOnCategoryPageGoToCategoryPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad1GoToCategoryPage
		$I->click(".tree-actions a:last-child"); // stepKey: expandAllGoToCategoryPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad2GoToCategoryPage
		$I->click("//a/span[contains(text(), '" . $I->retrieveEntityField('simpleSubCategory1', 'Name', 'test') . "')]"); // stepKey: navigateToCreatedCategoryGoToCategoryPage
		$I->waitForPageLoad(30); // stepKey: navigateToCreatedCategoryGoToCategoryPageWaitForPageLoad
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForSpinnerGoToCategoryPage
		$I->comment("Exiting Action Group [goToCategoryPage] NavigateToCreatedCategoryActionGroup");
		$I->comment("Entering Action Group [changeCategoryUrlKey] ChangeSeoUrlKeyActionGroup");
		$I->conditionalClick("div[data-index='search_engine_optimization'] .fieldset-wrapper-title", "div[data-index='search_engine_optimization'] .admin__fieldset-wrapper-content", false); // stepKey: openSeoSectionChangeCategoryUrlKey
		$I->fillField("input[name='url_key']", $I->retrieveEntityField('simpleSubCategory1', 'custom_attributes[url_key]', 'test') . "new"); // stepKey: enterURLKeyChangeCategoryUrlKey
		$I->click(".page-actions-inner #save"); // stepKey: saveCategoryChangeCategoryUrlKey
		$I->waitForPageLoad(30); // stepKey: saveCategoryChangeCategoryUrlKeyWaitForPageLoad
		$I->seeElement(".message-success"); // stepKey: assertSuccessMessageChangeCategoryUrlKey
		$I->comment("Exiting Action Group [changeCategoryUrlKey] ChangeSeoUrlKeyActionGroup");
		$I->comment("3. Edit Category 1 for DEFAULT Store View:");
		$I->comment("4. Change URL key for category and save changes");
		$I->comment("5. Open Marketing - SEO & Search - URL Rewrites");
		$I->comment("Entering Action Group [searchingUrlRewriteSecondTime] AdminSearchUrlRewriteByRequestPathActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/url_rewrite/index/"); // stepKey: openUrlRewriteEditPageSearchingUrlRewriteSecondTime
		$I->waitForPageLoad(30); // stepKey: waitForUrlRewriteEditPageToLoadSearchingUrlRewriteSecondTime
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersSearchingUrlRewriteSecondTime
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersSearchingUrlRewriteSecondTimeWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadSearchingUrlRewriteSecondTime
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openUrlRewriteGridFiltersSearchingUrlRewriteSecondTime
		$I->waitForPageLoad(30); // stepKey: openUrlRewriteGridFiltersSearchingUrlRewriteSecondTimeWaitForPageLoad
		$I->fillField(".admin__data-grid-filters input[name='request_path']", $I->retrieveEntityField('createSimpleProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: fillRequestPathFilterSearchingUrlRewriteSecondTime
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickOrderApplyFiltersSearchingUrlRewriteSecondTime
		$I->waitForPageLoad(30); // stepKey: clickOrderApplyFiltersSearchingUrlRewriteSecondTimeWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoad1SearchingUrlRewriteSecondTime
		$I->comment("Exiting Action Group [searchingUrlRewriteSecondTime] AdminSearchUrlRewriteByRequestPathActionGroup");
		$I->comment("Entering Action Group [seeInListValueOne] AssertAdminRequestPathInUrlRewriteGrigActionGroup");
		$I->seeElement("//*[@data-role='grid']//tbody//td[count(//*[@data-role='grid']//th[contains(., 'Request Path')]/preceding-sibling::th)+1][normalize-space(.)='" . $I->retrieveEntityField('createSimpleProduct', 'custom_attributes[url_key]', 'test') . ".html']"); // stepKey: seeValueInGridSeeInListValueOne
		$I->comment("Exiting Action Group [seeInListValueOne] AssertAdminRequestPathInUrlRewriteGrigActionGroup");
		$I->comment("Entering Action Group [seeInListValueTwo] AssertAdminRequestPathInUrlRewriteGrigActionGroup");
		$I->seeElement("//*[@data-role='grid']//tbody//td[count(//*[@data-role='grid']//th[contains(., 'Request Path')]/preceding-sibling::th)+1][normalize-space(.)='" . $I->retrieveEntityField('simpleSubCategory1', 'custom_attributes[url_key]', 'test') . "/" . $I->retrieveEntityField('createSimpleProduct', 'custom_attributes[url_key]', 'test') . ".html']"); // stepKey: seeValueInGridSeeInListValueTwo
		$I->comment("Exiting Action Group [seeInListValueTwo] AssertAdminRequestPathInUrlRewriteGrigActionGroup");
		$I->comment("Entering Action Group [seeInListValuethree] AssertAdminRequestPathInUrlRewriteGrigActionGroup");
		$I->seeElement("//*[@data-role='grid']//tbody//td[count(//*[@data-role='grid']//th[contains(., 'Request Path')]/preceding-sibling::th)+1][normalize-space(.)='" . $I->retrieveEntityField('simpleSubCategory1', 'custom_attributes[url_key]', 'test') . "/" . $I->retrieveEntityField('simpleSubCategory2', 'custom_attributes[url_key]', 'test') . "/" . $I->retrieveEntityField('createSimpleProduct', 'custom_attributes[url_key]', 'test') . ".html']"); // stepKey: seeValueInGridSeeInListValuethree
		$I->comment("Exiting Action Group [seeInListValuethree] AssertAdminRequestPathInUrlRewriteGrigActionGroup");
		$I->comment("Entering Action Group [seeInListValueFour] AssertAdminRequestPathInUrlRewriteGrigActionGroup");
		$I->seeElement("//*[@data-role='grid']//tbody//td[count(//*[@data-role='grid']//th[contains(., 'Request Path')]/preceding-sibling::th)+1][normalize-space(.)='" . $I->retrieveEntityField('simpleSubCategory1', 'custom_attributes[url_key]', 'test') . "/" . $I->retrieveEntityField('simpleSubCategory2', 'custom_attributes[url_key]', 'test') . "/" . $I->retrieveEntityField('simpleSubCategory3', 'custom_attributes[url_key]', 'test') . "/" . $I->retrieveEntityField('createSimpleProduct', 'custom_attributes[url_key]', 'test') . ".html']"); // stepKey: seeValueInGridSeeInListValueFour
		$I->comment("Exiting Action Group [seeInListValueFour] AssertAdminRequestPathInUrlRewriteGrigActionGroup");
		$I->comment("Entering Action Group [seeInListValueFive] AssertAdminRequestPathInUrlRewriteGrigActionGroup");
		$I->seeElement("//*[@data-role='grid']//tbody//td[count(//*[@data-role='grid']//th[contains(., 'Request Path')]/preceding-sibling::th)+1][normalize-space(.)='" . $I->retrieveEntityField('simpleSubCategory1', 'custom_attributes[url_key]', 'test') . "new/" . $I->retrieveEntityField('createSimpleProduct', 'custom_attributes[url_key]', 'test') . ".html']"); // stepKey: seeValueInGridSeeInListValueFive
		$I->comment("Exiting Action Group [seeInListValueFive] AssertAdminRequestPathInUrlRewriteGrigActionGroup");
		$I->comment("Entering Action Group [seeInListValue1Six] AssertAdminRequestPathInUrlRewriteGrigActionGroup");
		$I->seeElement("//*[@data-role='grid']//tbody//td[count(//*[@data-role='grid']//th[contains(., 'Request Path')]/preceding-sibling::th)+1][normalize-space(.)='" . $I->retrieveEntityField('simpleSubCategory1', 'custom_attributes[url_key]', 'test') . "new/" . $I->retrieveEntityField('simpleSubCategory2', 'custom_attributes[url_key]', 'test') . "/" . $I->retrieveEntityField('createSimpleProduct', 'custom_attributes[url_key]', 'test') . ".html']"); // stepKey: seeValueInGridSeeInListValue1Six
		$I->comment("Exiting Action Group [seeInListValue1Six] AssertAdminRequestPathInUrlRewriteGrigActionGroup");
		$I->comment("Entering Action Group [seeInListValueSeven] AssertAdminRequestPathInUrlRewriteGrigActionGroup");
		$I->seeElement("//*[@data-role='grid']//tbody//td[count(//*[@data-role='grid']//th[contains(., 'Request Path')]/preceding-sibling::th)+1][normalize-space(.)='" . $I->retrieveEntityField('simpleSubCategory1', 'custom_attributes[url_key]', 'test') . "new/" . $I->retrieveEntityField('simpleSubCategory2', 'custom_attributes[url_key]', 'test') . "/" . $I->retrieveEntityField('simpleSubCategory3', 'custom_attributes[url_key]', 'test') . "/" . $I->retrieveEntityField('createSimpleProduct', 'custom_attributes[url_key]', 'test') . ".html']"); // stepKey: seeValueInGridSeeInListValueSeven
		$I->comment("Exiting Action Group [seeInListValueSeven] AssertAdminRequestPathInUrlRewriteGrigActionGroup");
		$I->comment("3. Edit Category 1 for All store view:");
		$I->comment("4. Change URL key for category and save changes");
	}
}
