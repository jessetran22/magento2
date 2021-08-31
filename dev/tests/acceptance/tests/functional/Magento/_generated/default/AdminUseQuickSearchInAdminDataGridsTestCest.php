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
 * @Title("MC-27559: [CMS Grids] Use quick search in Admin data grids")
 * @Description("Verify that Merchant can use quick search in order to simplify the data grid filtering in Admin<h3>Test files</h3>app/code/Magento/Cms/Test/Mftf/Test/AdminUseQuickSearchInAdminDataGridsTest.xml<br>")
 * @TestCaseId("MC-27559")
 * @group cms
 * @group ui
 */
class AdminUseQuickSearchInAdminDataGridsTestCest
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
    }
	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _before(AcceptanceTester $I)
	{
		$I->createEntity("createFirstCMSPage", "hook", "simpleCmsPage", [], []); // stepKey: createFirstCMSPage
		$I->createEntity("createSecondCMSPage", "hook", "_newDefaultCmsPage", [], []); // stepKey: createSecondCMSPage
		$I->createEntity("createThirdCMSPage", "hook", "_emptyCmsPage", [], []); // stepKey: createThirdCMSPage
		$I->createEntity("createFirstCmsBlock", "hook", "Sales25offBlock", [], []); // stepKey: createFirstCmsBlock
		$I->createEntity("createSecondCmsBlock", "hook", "ActiveTestBlock", [], []); // stepKey: createSecondCmsBlock
		$I->createEntity("createThirdCmsBlock", "hook", "_emptyCmsBlock", [], []); // stepKey: createThirdCmsBlock
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
		$I->deleteEntity("createFirstCMSPage", "hook"); // stepKey: deleteFirstCMSPage
		$I->deleteEntity("createSecondCMSPage", "hook"); // stepKey: deleteSecondCMSPage
		$I->deleteEntity("createThirdCMSPage", "hook"); // stepKey: deleteThirdCMSPage
		$I->deleteEntity("createFirstCmsBlock", "hook"); // stepKey: deleteFirstCmsBlock
		$I->deleteEntity("createSecondCmsBlock", "hook"); // stepKey: deleteSecondCmsBlock
		$I->deleteEntity("createThirdCmsBlock", "hook"); // stepKey: deleteThirdCmsBlock
		$I->comment("Entering Action Group [navigateToCMSPageGrid] AdminOpenCMSPagesGridActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/cms/page"); // stepKey: navigateToCMSPagesGridNavigateToCMSPageGrid
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadNavigateToCMSPageGrid
		$I->comment("Exiting Action Group [navigateToCMSPageGrid] AdminOpenCMSPagesGridActionGroup");
		$I->comment("Entering Action Group [clearCmsPagesGridFilters] AdminGridFilterResetActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollToTopClearCmsPagesGridFilters
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clearExistingFiltersClearCmsPagesGridFilters
		$I->waitForPageLoad(30); // stepKey: waitForFiltersResetClearCmsPagesGridFilters
		$I->comment("Exiting Action Group [clearCmsPagesGridFilters] AdminGridFilterResetActionGroup");
		$I->comment("Entering Action Group [navigateToCmsBlockGrid] AdminOpenCmsBlocksGridActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/cms/block/"); // stepKey: navigateToCMSBlocksGridNavigateToCmsBlockGrid
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadNavigateToCmsBlockGrid
		$I->comment("Exiting Action Group [navigateToCmsBlockGrid] AdminOpenCmsBlocksGridActionGroup");
		$I->comment("Entering Action Group [clearCmsBlockGridFilters] AdminGridFilterResetActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollToTopClearCmsBlockGridFilters
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clearExistingFiltersClearCmsBlockGridFilters
		$I->waitForPageLoad(30); // stepKey: waitForFiltersResetClearCmsBlockGridFilters
		$I->comment("Exiting Action Group [clearCmsBlockGridFilters] AdminGridFilterResetActionGroup");
		$I->comment("Entering Action Group [logoutFromAdmin] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogoutFromAdmin
		$I->comment("Exiting Action Group [logoutFromAdmin] AdminLogoutActionGroup");
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
	 * @Features({"Cms"})
	 * @Stories({"Create CMS Page"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminUseQuickSearchInAdminDataGridsTest(AcceptanceTester $I)
	{
		$I->comment("Go to \"Cms Pages Grid\" page and filter by title");
		$I->comment("Entering Action Group [navigateToCmsPageGrid] AdminOpenCMSPagesGridActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/cms/page"); // stepKey: navigateToCMSPagesGridNavigateToCmsPageGrid
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadNavigateToCmsPageGrid
		$I->comment("Exiting Action Group [navigateToCmsPageGrid] AdminOpenCMSPagesGridActionGroup");
		$I->comment("Entering Action Group [searchFirstCmsPage] SearchAdminDataGridByKeywordActionGroup");
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersSearchFirstCmsPage
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersSearchFirstCmsPageWaitForPageLoad
		$I->fillField(".admin__data-grid-header[data-bind='afterRender: \$data.setToolbarNode'] input[placeholder='Search by keyword']", $I->retrieveEntityField('createFirstCMSPage', 'title', 'test')); // stepKey: fillKeywordSearchFieldSearchFirstCmsPage
		$I->click(".data-grid-search-control-wrap > button.action-submit"); // stepKey: clickKeywordSearchSearchFirstCmsPage
		$I->waitForPageLoad(30); // stepKey: clickKeywordSearchSearchFirstCmsPageWaitForPageLoad
		$I->comment("Exiting Action Group [searchFirstCmsPage] SearchAdminDataGridByKeywordActionGroup");
		$I->see($I->retrieveEntityField('createFirstCMSPage', 'title', 'test'), "tr[data-repeat-index='0']"); // stepKey: seeFirstCmsPageAfterFiltering
		$I->comment("Entering Action Group [assertNumberOfRecordsInCmsPageGrid] AdminAssertNumberOfRecordsInUiGridActionGroup");
		$I->see("1 records found", "div.admin__data-grid-header-row.row.row-gutter div.row div.admin__control-support-text"); // stepKey: seeRecordsAssertNumberOfRecordsInCmsPageGrid
		$I->comment("Exiting Action Group [assertNumberOfRecordsInCmsPageGrid] AdminAssertNumberOfRecordsInUiGridActionGroup");
		$I->comment("Entering Action Group [searchSecondCmsPage] SearchAdminDataGridByKeywordActionGroup");
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersSearchSecondCmsPage
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersSearchSecondCmsPageWaitForPageLoad
		$I->fillField(".admin__data-grid-header[data-bind='afterRender: \$data.setToolbarNode'] input[placeholder='Search by keyword']", $I->retrieveEntityField('createSecondCMSPage', 'title', 'test')); // stepKey: fillKeywordSearchFieldSearchSecondCmsPage
		$I->click(".data-grid-search-control-wrap > button.action-submit"); // stepKey: clickKeywordSearchSearchSecondCmsPage
		$I->waitForPageLoad(30); // stepKey: clickKeywordSearchSearchSecondCmsPageWaitForPageLoad
		$I->comment("Exiting Action Group [searchSecondCmsPage] SearchAdminDataGridByKeywordActionGroup");
		$I->see($I->retrieveEntityField('createSecondCMSPage', 'title', 'test'), "tr[data-repeat-index='0']"); // stepKey: seeSecondCmsPageAfterFiltering
		$I->comment("Entering Action Group [assertNumberOfRecordsAfterFilteringSecondCmsPage] AdminAssertNumberOfRecordsInUiGridActionGroup");
		$I->see("1 records found", "div.admin__data-grid-header-row.row.row-gutter div.row div.admin__control-support-text"); // stepKey: seeRecordsAssertNumberOfRecordsAfterFilteringSecondCmsPage
		$I->comment("Exiting Action Group [assertNumberOfRecordsAfterFilteringSecondCmsPage] AdminAssertNumberOfRecordsInUiGridActionGroup");
		$I->comment("Entering Action Group [clearGridFilters] AdminGridFilterResetActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollToTopClearGridFilters
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clearExistingFiltersClearGridFilters
		$I->waitForPageLoad(30); // stepKey: waitForFiltersResetClearGridFilters
		$I->comment("Exiting Action Group [clearGridFilters] AdminGridFilterResetActionGroup");
		$grabTotalRecordsCmsPagesBeforeClickSearchButton = $I->grabTextFrom("div.admin__data-grid-header-row.row.row-gutter div.row div.admin__control-support-text"); // stepKey: grabTotalRecordsCmsPagesBeforeClickSearchButton
		$I->click(".data-grid-search-control-wrap > button.action-submit"); // stepKey: clickSearchMagnifierButton
		$I->waitForPageLoad(30); // stepKey: clickSearchMagnifierButtonWaitForPageLoad
		$grabTotalRecordsCmsPagesAfterClickSearchButton = $I->grabTextFrom("div.admin__data-grid-header-row.row.row-gutter div.row div.admin__control-support-text"); // stepKey: grabTotalRecordsCmsPagesAfterClickSearchButton
		$I->assertEquals("$grabTotalRecordsCmsPagesBeforeClickSearchButton", "$grabTotalRecordsCmsPagesAfterClickSearchButton"); // stepKey: assertTotalRecordsCmsPages
		$I->comment("Entering Action Group [enterNonExistentEntityInQuickSearch] SearchAdminDataGridByKeywordActionGroup");
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersEnterNonExistentEntityInQuickSearch
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersEnterNonExistentEntityInQuickSearchWaitForPageLoad
		$I->fillField(".admin__data-grid-header[data-bind='afterRender: \$data.setToolbarNode'] input[placeholder='Search by keyword']", "{{TestQueryNonExistentEntity}}"); // stepKey: fillKeywordSearchFieldEnterNonExistentEntityInQuickSearch
		$I->click(".data-grid-search-control-wrap > button.action-submit"); // stepKey: clickKeywordSearchEnterNonExistentEntityInQuickSearch
		$I->waitForPageLoad(30); // stepKey: clickKeywordSearchEnterNonExistentEntityInQuickSearchWaitForPageLoad
		$I->comment("Exiting Action Group [enterNonExistentEntityInQuickSearch] SearchAdminDataGridByKeywordActionGroup");
		$I->dontSeeElement("table.data-grid tbody > tr.data-row"); // stepKey: dontSeeResultRows
		$I->comment("Entering Action Group [assertNumberOfRecordsAfterFilteringNonExistentCmsPage] AdminAssertNumberOfRecordsInUiGridActionGroup");
		$I->see("0 records found", "div.admin__data-grid-header-row.row.row-gutter div.row div.admin__control-support-text"); // stepKey: seeRecordsAssertNumberOfRecordsAfterFilteringNonExistentCmsPage
		$I->comment("Exiting Action Group [assertNumberOfRecordsAfterFilteringNonExistentCmsPage] AdminAssertNumberOfRecordsInUiGridActionGroup");
		$I->comment("Entering Action Group [searchThirdCmsPage] SearchAdminDataGridByKeywordActionGroup");
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersSearchThirdCmsPage
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersSearchThirdCmsPageWaitForPageLoad
		$I->fillField(".admin__data-grid-header[data-bind='afterRender: \$data.setToolbarNode'] input[placeholder='Search by keyword']", $I->retrieveEntityField('createThirdCMSPage', 'title', 'test')); // stepKey: fillKeywordSearchFieldSearchThirdCmsPage
		$I->click(".data-grid-search-control-wrap > button.action-submit"); // stepKey: clickKeywordSearchSearchThirdCmsPage
		$I->waitForPageLoad(30); // stepKey: clickKeywordSearchSearchThirdCmsPageWaitForPageLoad
		$I->comment("Exiting Action Group [searchThirdCmsPage] SearchAdminDataGridByKeywordActionGroup");
		$I->see($I->retrieveEntityField('createThirdCMSPage', 'title', 'test'), "tr[data-repeat-index='0']"); // stepKey: seeThirdCmsPageAfterFiltering
		$I->comment("Entering Action Group [assertNumberOfRecordsAfterFilteringThirdCmsPage] AdminAssertNumberOfRecordsInUiGridActionGroup");
		$I->see("1 records found", "div.admin__data-grid-header-row.row.row-gutter div.row div.admin__control-support-text"); // stepKey: seeRecordsAssertNumberOfRecordsAfterFilteringThirdCmsPage
		$I->comment("Exiting Action Group [assertNumberOfRecordsAfterFilteringThirdCmsPage] AdminAssertNumberOfRecordsInUiGridActionGroup");
		$I->comment("Go to \"Cms Blocks Grid\" page and filter by title");
		$I->comment("Entering Action Group [navigateToCmsBlockGrid] AdminOpenCmsBlocksGridActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/cms/block/"); // stepKey: navigateToCMSBlocksGridNavigateToCmsBlockGrid
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadNavigateToCmsBlockGrid
		$I->comment("Exiting Action Group [navigateToCmsBlockGrid] AdminOpenCmsBlocksGridActionGroup");
		$I->comment("Entering Action Group [searchFirstCmsBlock] SearchAdminDataGridByKeywordActionGroup");
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersSearchFirstCmsBlock
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersSearchFirstCmsBlockWaitForPageLoad
		$I->fillField(".admin__data-grid-header[data-bind='afterRender: \$data.setToolbarNode'] input[placeholder='Search by keyword']", $I->retrieveEntityField('createFirstCmsBlock', 'title', 'test')); // stepKey: fillKeywordSearchFieldSearchFirstCmsBlock
		$I->click(".data-grid-search-control-wrap > button.action-submit"); // stepKey: clickKeywordSearchSearchFirstCmsBlock
		$I->waitForPageLoad(30); // stepKey: clickKeywordSearchSearchFirstCmsBlockWaitForPageLoad
		$I->comment("Exiting Action Group [searchFirstCmsBlock] SearchAdminDataGridByKeywordActionGroup");
		$I->see($I->retrieveEntityField('createFirstCmsBlock', 'title', 'test'), "tr[data-repeat-index='0']"); // stepKey: seeFirstCmsBlockAfterFiltering
		$I->comment("Entering Action Group [assertNumberOfRecordsInBlockGrid] AdminAssertNumberOfRecordsInUiGridActionGroup");
		$I->see("1 records found", "div.admin__data-grid-header-row.row.row-gutter div.row div.admin__control-support-text"); // stepKey: seeRecordsAssertNumberOfRecordsInBlockGrid
		$I->comment("Exiting Action Group [assertNumberOfRecordsInBlockGrid] AdminAssertNumberOfRecordsInUiGridActionGroup");
		$I->comment("Entering Action Group [searchSecondCmsBlock] SearchAdminDataGridByKeywordActionGroup");
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersSearchSecondCmsBlock
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersSearchSecondCmsBlockWaitForPageLoad
		$I->fillField(".admin__data-grid-header[data-bind='afterRender: \$data.setToolbarNode'] input[placeholder='Search by keyword']", $I->retrieveEntityField('createSecondCmsBlock', 'title', 'test')); // stepKey: fillKeywordSearchFieldSearchSecondCmsBlock
		$I->click(".data-grid-search-control-wrap > button.action-submit"); // stepKey: clickKeywordSearchSearchSecondCmsBlock
		$I->waitForPageLoad(30); // stepKey: clickKeywordSearchSearchSecondCmsBlockWaitForPageLoad
		$I->comment("Exiting Action Group [searchSecondCmsBlock] SearchAdminDataGridByKeywordActionGroup");
		$I->see($I->retrieveEntityField('createSecondCmsBlock', 'title', 'test'), "tr[data-repeat-index='0']"); // stepKey: seeSecondCmsBlockAfterFiltering
		$I->comment("Entering Action Group [assertNumberOfRecordsAfterFilteringSecondBlock] AdminAssertNumberOfRecordsInUiGridActionGroup");
		$I->see("1 records found", "div.admin__data-grid-header-row.row.row-gutter div.row div.admin__control-support-text"); // stepKey: seeRecordsAssertNumberOfRecordsAfterFilteringSecondBlock
		$I->comment("Exiting Action Group [assertNumberOfRecordsAfterFilteringSecondBlock] AdminAssertNumberOfRecordsInUiGridActionGroup");
		$I->comment("Entering Action Group [clearGridFiltersOnBlocksGridPage] AdminGridFilterResetActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollToTopClearGridFiltersOnBlocksGridPage
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clearExistingFiltersClearGridFiltersOnBlocksGridPage
		$I->waitForPageLoad(30); // stepKey: waitForFiltersResetClearGridFiltersOnBlocksGridPage
		$I->comment("Exiting Action Group [clearGridFiltersOnBlocksGridPage] AdminGridFilterResetActionGroup");
		$grabTotalRecordsBlocksBeforeClickSearchButton = $I->grabTextFrom("div.admin__data-grid-header-row.row.row-gutter div.row div.admin__control-support-text"); // stepKey: grabTotalRecordsBlocksBeforeClickSearchButton
		$I->click(".data-grid-search-control-wrap > button.action-submit"); // stepKey: clickSearchMagnifierButtonOnBlocksGridPage
		$I->waitForPageLoad(30); // stepKey: clickSearchMagnifierButtonOnBlocksGridPageWaitForPageLoad
		$grabTotalRecordsBlocksAfterClickSearchButton = $I->grabTextFrom("div.admin__data-grid-header-row.row.row-gutter div.row div.admin__control-support-text"); // stepKey: grabTotalRecordsBlocksAfterClickSearchButton
		$I->assertEquals("$grabTotalRecordsBlocksBeforeClickSearchButton", "$grabTotalRecordsBlocksAfterClickSearchButton"); // stepKey: assertTotalRecordsBlocks
		$I->comment("Entering Action Group [enterNonExistentEntityInQuickSearchOnBlocksGridPage] SearchAdminDataGridByKeywordActionGroup");
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersEnterNonExistentEntityInQuickSearchOnBlocksGridPage
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersEnterNonExistentEntityInQuickSearchOnBlocksGridPageWaitForPageLoad
		$I->fillField(".admin__data-grid-header[data-bind='afterRender: \$data.setToolbarNode'] input[placeholder='Search by keyword']", "{{TestQueryNonExistentEntity}}"); // stepKey: fillKeywordSearchFieldEnterNonExistentEntityInQuickSearchOnBlocksGridPage
		$I->click(".data-grid-search-control-wrap > button.action-submit"); // stepKey: clickKeywordSearchEnterNonExistentEntityInQuickSearchOnBlocksGridPage
		$I->waitForPageLoad(30); // stepKey: clickKeywordSearchEnterNonExistentEntityInQuickSearchOnBlocksGridPageWaitForPageLoad
		$I->comment("Exiting Action Group [enterNonExistentEntityInQuickSearchOnBlocksGridPage] SearchAdminDataGridByKeywordActionGroup");
		$I->dontSeeElement("table.data-grid tbody > tr.data-row"); // stepKey: dontSeeResultRowsOnBlocksGrid
		$I->comment("Entering Action Group [assertNumberOfRecordsAfterFilteringNonExistentCmsBlock] AdminAssertNumberOfRecordsInUiGridActionGroup");
		$I->see("0 records found", "div.admin__data-grid-header-row.row.row-gutter div.row div.admin__control-support-text"); // stepKey: seeRecordsAssertNumberOfRecordsAfterFilteringNonExistentCmsBlock
		$I->comment("Exiting Action Group [assertNumberOfRecordsAfterFilteringNonExistentCmsBlock] AdminAssertNumberOfRecordsInUiGridActionGroup");
		$I->comment("Entering Action Group [searchThirdCmsBlock] SearchAdminDataGridByKeywordActionGroup");
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersSearchThirdCmsBlock
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersSearchThirdCmsBlockWaitForPageLoad
		$I->fillField(".admin__data-grid-header[data-bind='afterRender: \$data.setToolbarNode'] input[placeholder='Search by keyword']", $I->retrieveEntityField('createThirdCmsBlock', 'title', 'test')); // stepKey: fillKeywordSearchFieldSearchThirdCmsBlock
		$I->click(".data-grid-search-control-wrap > button.action-submit"); // stepKey: clickKeywordSearchSearchThirdCmsBlock
		$I->waitForPageLoad(30); // stepKey: clickKeywordSearchSearchThirdCmsBlockWaitForPageLoad
		$I->comment("Exiting Action Group [searchThirdCmsBlock] SearchAdminDataGridByKeywordActionGroup");
		$I->see($I->retrieveEntityField('createThirdCmsBlock', 'title', 'test'), "tr[data-repeat-index='0']"); // stepKey: seeThirdCmsBlockAfterFiltering
		$I->comment("Entering Action Group [assertNumberOfRecordsAfterFilteringThirdBlock] AdminAssertNumberOfRecordsInUiGridActionGroup");
		$I->see("1 records found", "div.admin__data-grid-header-row.row.row-gutter div.row div.admin__control-support-text"); // stepKey: seeRecordsAssertNumberOfRecordsAfterFilteringThirdBlock
		$I->comment("Exiting Action Group [assertNumberOfRecordsAfterFilteringThirdBlock] AdminAssertNumberOfRecordsInUiGridActionGroup");
	}
}
