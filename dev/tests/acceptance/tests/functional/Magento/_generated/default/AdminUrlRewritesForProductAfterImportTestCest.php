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
 * @Title("MC-20229: Verify the number of URL rewrites when edit or import product")
 * @Description("After importing products to admin verify the number of URL including categories matches<h3>Test files</h3>app/code/Magento/UrlRewrite/Test/Mftf/Test/AdminUrlRewritesForProductAfterImportTest.xml<br>")
 * @TestCaseId("MC-20229")
 * @group urlRewrite
 */
class AdminUrlRewritesForProductAfterImportTestCest
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
		$I->comment("Set the configuration for Generate category/product URL Rewrites");
		$I->comment("Enable config to generate category/product URL Rewrites ");
		$enableGenerateUrlRewrite = $I->magentoCLI("config:set catalog/seo/generate_category_product_rewrites 1", 60); // stepKey: enableGenerateUrlRewrite
		$I->comment($enableGenerateUrlRewrite);
		$simpleSubCategory1Fields['parent_id'] = "2";
		$I->createEntity("simpleSubCategory1", "hook", "NewRootCategory", [], $simpleSubCategory1Fields); // stepKey: simpleSubCategory1
		$I->createEntity("simpleSubCategory2", "hook", "SubCategoryWithParent", ["simpleSubCategory1"], []); // stepKey: simpleSubCategory2
		$I->createEntity("simpleSubCategory3", "hook", "SubCategoryWithParent", ["simpleSubCategory2"], []); // stepKey: simpleSubCategory3
		$I->comment("Create Simple product 1 and assign it to Category 3 ");
		$I->createEntity("createSimpleProduct", "hook", "SimpleProductAfterImport1", ["simpleSubCategory3"], []); // stepKey: createSimpleProduct
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Delete all products that replaced products in the before block post import ");
		$I->deleteEntityByUrl("/V1/products/SimpleProductForTest1"); // stepKey: deleteSimpleProduct1
		$I->deleteEntity("simpleSubCategory3", "hook"); // stepKey: deleteSimpleSubCategory3
		$I->deleteEntity("simpleSubCategory2", "hook"); // stepKey: deleteSimpleSubCategory2
		$I->deleteEntity("simpleSubCategory1", "hook"); // stepKey: deleteSimpleSubCategory1
		$I->comment("Disable config to generate category/product URL Rewrites ");
		$disableGenerateUrlRewrite = $I->magentoCLI("config:set catalog/seo/generate_category_product_rewrites 1", 60); // stepKey: disableGenerateUrlRewrite
		$I->comment($disableGenerateUrlRewrite);
		$I->comment("Entering Action Group [amOnLogoutPage] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageAmOnLogoutPage
		$I->comment("Exiting Action Group [amOnLogoutPage] AdminLogoutActionGroup");
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
	 * @Stories({"Different number of URL rewrites when editing or importing a product"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminUrlRewritesForProductAfterImportTest(AcceptanceTester $I)
	{
		$I->comment("1. Log in to Admin ");
		$I->comment("Entering Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdminWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin
		$I->comment("Exiting Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->comment("2. Open Marketing - SEO and Search - URL Rewrites ");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/url_rewrite/index/"); // stepKey: amOnUrlRewriteIndexPage
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openUrlRewriteGridFilters
		$I->waitForPageLoad(30); // stepKey: openUrlRewriteGridFiltersWaitForPageLoad
		$I->fillField(".admin__data-grid-filters input[name='request_path']", $I->retrieveEntityField('createSimpleProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: inputProductName
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickSearchButton
		$I->waitForPageLoad(30); // stepKey: clickSearchButtonWaitForPageLoad
		$I->seeElement("//*[@data-role='grid']//tbody//td[count(//*[@data-role='grid']//th[contains(., 'Request Path')]/preceding-sibling::th)+1][normalize-space(.)='" . $I->retrieveEntityField('createSimpleProduct', 'custom_attributes[url_key]', 'test') . ".html']"); // stepKey: seeValue1
		$I->seeElement("//*[@data-role='grid']//tbody//td[count(//*[@data-role='grid']//th[contains(., 'Request Path')]/preceding-sibling::th)+1][normalize-space(.)='" . $I->retrieveEntityField('simpleSubCategory1', 'custom_attributes[url_key]', 'test') . "/" . $I->retrieveEntityField('createSimpleProduct', 'custom_attributes[url_key]', 'test') . ".html']"); // stepKey: seeValue2
		$I->seeElement("//*[@data-role='grid']//tbody//td[count(//*[@data-role='grid']//th[contains(., 'Request Path')]/preceding-sibling::th)+1][normalize-space(.)='" . $I->retrieveEntityField('simpleSubCategory1', 'custom_attributes[url_key]', 'test') . "/" . $I->retrieveEntityField('simpleSubCategory2', 'custom_attributes[url_key]', 'test') . "/" . $I->retrieveEntityField('createSimpleProduct', 'custom_attributes[url_key]', 'test') . ".html']"); // stepKey: seeValue3
		$I->seeElement("//*[@data-role='grid']//tbody//td[count(//*[@data-role='grid']//th[contains(., 'Request Path')]/preceding-sibling::th)+1][normalize-space(.)='" . $I->retrieveEntityField('simpleSubCategory1', 'custom_attributes[url_key]', 'test') . "/" . $I->retrieveEntityField('simpleSubCategory2', 'custom_attributes[url_key]', 'test') . "/" . $I->retrieveEntityField('simpleSubCategory3', 'custom_attributes[url_key]', 'test') . "/" . $I->retrieveEntityField('createSimpleProduct', 'custom_attributes[url_key]', 'test') . ".html']"); // stepKey: seeValue4
		$I->comment("3. Import products with add/update behavior ");
		$I->comment("Entering Action Group [adminImportProducts] AdminImportProductsActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/import/"); // stepKey: goToImportIndexPageAdminImportProducts
		$I->waitForPageLoad(30); // stepKey: adminImportMainSectionLoadAdminImportProducts
		$I->selectOption("#entity", "Products"); // stepKey: selectProductsOptionAdminImportProducts
		$I->waitForElementVisible("#basic_behavior", 30); // stepKey: waitForImportBehaviorElementVisibleAdminImportProducts
		$I->selectOption("#basic_behavior", "Add/Update"); // stepKey: selectImportBehaviorOptionAdminImportProducts
		$I->selectOption("#basic_behaviorvalidation_strategy", "Stop on Error"); // stepKey: selectValidationStrategyOptionAdminImportProducts
		$I->fillField("#basic_behavior_allowed_error_count", "10"); // stepKey: fillAllowedErrorsCountFieldAdminImportProducts
		$I->attachFile("#import_file", "catalog_import_products_url_rewrite.csv"); // stepKey: attachFileForImportAdminImportProducts
		$I->click("#upload_button"); // stepKey: clickCheckDataButtonAdminImportProducts
		$I->waitForPageLoad(30); // stepKey: clickCheckDataButtonAdminImportProductsWaitForPageLoad
		$I->click("#import_validation_container button"); // stepKey: clickImportButtonAdminImportProducts
		$I->waitForPageLoad(30); // stepKey: clickImportButtonAdminImportProductsWaitForPageLoad
		$I->waitForElementVisible("#import_validation_messages .message-notice", 30); // stepKey: waitForNoticeMessageAdminImportProducts
		$I->see("Created: 0, Updated: 1, Deleted: 0", "#import_validation_messages .message-notice"); // stepKey: seeNoticeMessageAdminImportProducts
		$I->see("Import successfully done", "#import_validation_messages .message-success"); // stepKey: seeImportMessageAdminImportProducts
		$I->comment("Exiting Action Group [adminImportProducts] AdminImportProductsActionGroup");
		$I->comment("4. Assert Simple Product1 on grid ");
		$I->comment("Entering Action Group [assertSimpleProduct1OnAdminGrid] AssertProductOnAdminGridActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: visitAdminProductPageAssertSimpleProduct1OnAdminGrid
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadInitialAssertSimpleProduct1OnAdminGrid
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersInitialAssertSimpleProduct1OnAdminGrid
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersInitialAssertSimpleProduct1OnAdminGridWaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFiltersAssertSimpleProduct1OnAdminGrid
		$I->fillField("input.admin__control-text[name='name']", "SimpleProductAfterImport1"); // stepKey: fillProductNameFilterAssertSimpleProduct1OnAdminGrid
		$I->fillField("input.admin__control-text[name='sku']", "SimpleProductForTest1"); // stepKey: fillProductSkuFilterAssertSimpleProduct1OnAdminGrid
		$I->selectOption("select.admin__control-select[name='type_id']", "simple"); // stepKey: selectionProductTypeAssertSimpleProduct1OnAdminGrid
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersAssertSimpleProduct1OnAdminGrid
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersAssertSimpleProduct1OnAdminGridWaitForPageLoad
		$I->see("SimpleProductAfterImport1", "//tr[1]//td[count(//div[@data-role='grid-wrapper']//tr//th[normalize-space(.)='Name']/preceding-sibling::th) +1 ]"); // stepKey: seeProductNameInGridAssertSimpleProduct1OnAdminGrid
		$I->see("250.00", "//tr[1]//td[count(//div[@data-role='grid-wrapper']//tr//th[normalize-space(.)='Price']/preceding-sibling::th) +1 ]"); // stepKey: seeProductPriceInGridAssertSimpleProduct1OnAdminGrid
		$I->comment("Exiting Action Group [assertSimpleProduct1OnAdminGrid] AssertProductOnAdminGridActionGroup");
		$I->comment("5. Open Marketing - SEO and Search - URL Rewrites");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/url_rewrite/index/"); // stepKey: amOnUrlRewriteIndexPage2
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openUrlRewriteGridFilters2
		$I->waitForPageLoad(30); // stepKey: openUrlRewriteGridFilters2WaitForPageLoad
		$I->fillField(".admin__data-grid-filters input[name='request_path']", $I->retrieveEntityField('createSimpleProduct', 'custom_attributes[url_key]', 'test') . "-new.html"); // stepKey: inputProductName2
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickSearchButton2
		$I->waitForPageLoad(30); // stepKey: clickSearchButton2WaitForPageLoad
		$I->seeElement("//*[@data-role='grid']//tbody//td[count(//*[@data-role='grid']//th[contains(., 'Request Path')]/preceding-sibling::th)+1][normalize-space(.)='" . $I->retrieveEntityField('createSimpleProduct', 'custom_attributes[url_key]', 'test') . "-new.html']"); // stepKey: seeInListValue1
		$I->seeElement("//*[@data-role='grid']//tbody//td[count(//*[@data-role='grid']//th[contains(., 'Request Path')]/preceding-sibling::th)+1][normalize-space(.)='" . $I->retrieveEntityField('simpleSubCategory1', 'custom_attributes[url_key]', 'test') . "/" . $I->retrieveEntityField('createSimpleProduct', 'custom_attributes[url_key]', 'test') . "-new.html']"); // stepKey: seeInListValue2
		$I->seeElement("//*[@data-role='grid']//tbody//td[count(//*[@data-role='grid']//th[contains(., 'Request Path')]/preceding-sibling::th)+1][normalize-space(.)='" . $I->retrieveEntityField('simpleSubCategory1', 'custom_attributes[url_key]', 'test') . "/" . $I->retrieveEntityField('simpleSubCategory2', 'custom_attributes[url_key]', 'test') . "/" . $I->retrieveEntityField('createSimpleProduct', 'custom_attributes[url_key]', 'test') . "-new.html']"); // stepKey: seeInListValue3
		$I->seeElement("//*[@data-role='grid']//tbody//td[count(//*[@data-role='grid']//th[contains(., 'Request Path')]/preceding-sibling::th)+1][normalize-space(.)='" . $I->retrieveEntityField('simpleSubCategory1', 'custom_attributes[url_key]', 'test') . "/" . $I->retrieveEntityField('simpleSubCategory2', 'custom_attributes[url_key]', 'test') . "/" . $I->retrieveEntityField('simpleSubCategory3', 'custom_attributes[url_key]', 'test') . "/" . $I->retrieveEntityField('createSimpleProduct', 'custom_attributes[url_key]', 'test') . "-new.html']"); // stepKey: seeInListValue4
		$I->seeElement("//*[@data-role='grid']//tbody//td[count(//*[@data-role='grid']//th[contains(., 'Request Path')]/preceding-sibling::th)+1][normalize-space(.)='" . $I->retrieveEntityField('simpleSubCategory1', 'custom_attributes[url_key]', 'test') . "/" . $I->retrieveEntityField('createSimpleProduct', 'custom_attributes[url_key]', 'test') . "-new.html']"); // stepKey: seeInListValue5
		$I->seeElement("//*[@data-role='grid']//tbody//td[count(//*[@data-role='grid']//th[contains(., 'Request Path')]/preceding-sibling::th)+1][normalize-space(.)='" . $I->retrieveEntityField('simpleSubCategory1', 'custom_attributes[url_key]', 'test') . "/" . $I->retrieveEntityField('simpleSubCategory2', 'custom_attributes[url_key]', 'test') . "/" . $I->retrieveEntityField('createSimpleProduct', 'custom_attributes[url_key]', 'test') . "-new.html']"); // stepKey: seeInListValue6
		$I->seeElement("//*[@data-role='grid']//tbody//td[count(//*[@data-role='grid']//th[contains(., 'Request Path')]/preceding-sibling::th)+1][normalize-space(.)='" . $I->retrieveEntityField('simpleSubCategory1', 'custom_attributes[url_key]', 'test') . "/" . $I->retrieveEntityField('simpleSubCategory2', 'custom_attributes[url_key]', 'test') . "/" . $I->retrieveEntityField('simpleSubCategory3', 'custom_attributes[url_key]', 'test') . "/" . $I->retrieveEntityField('createSimpleProduct', 'custom_attributes[url_key]', 'test') . "-new.html']"); // stepKey: seeInListValue7
	}
}
